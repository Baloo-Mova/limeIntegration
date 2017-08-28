<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\PaymentsType;
use Carbon\Carbon;
use App\Http\Requests\Users\UpdateRequest;
use App\User;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Lime\LimeParticipants;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\Lime\LimeSurveys;
use App\Models\SearchCache;
use App\Models\Lime\LimeSurveysQuestionsAnswers;
use App\Models\Lime\LimeSurveysQuestions;
use Brian2694\Toastr\Facades\Toastr;

class AdminUsersController extends Controller
{
    //


    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {

        $users = User::where(['role_id'=>1])->orWhere(['role_id'=>3])->orderBy('id')->paginate(20);

        if(Lang::getLocale()=="ru"){
            $countries = Country::where(['lang_id'=> 'ru'])->get();
        }

        if(Lang::getLocale()=="uk"){
            $countries = Country::where(['lang_id'=> 'uk'])->get();
        }

        return view('admin.users.index')->with([
            'users' => $users,
            'countries' => isset($countries) ? $countries : [],

        ]);
    }

    public function exportUsers(Request $request)
    {
        $guid = $request->get('guid');

        if(!isset($guid)){
            Toastr::error("Не указан обязательный параметр!", "Ошибка");
            return back();
        }

        $users = DB::table('search_cache_' .$guid)->get();
        $users = collect($users)->map(function ($x) {
            return (array)$x;
        })->toArray();

        if(!isset($users)){
            Toastr::error("Таблицы результатов не существует!", "Ошибка");
            return back();
        }

        $u = User::whereIn('ls_participant_id', array_column($users, 'participant_id'))->get();

        if(!isset($u)){
            Toastr::error("Пользователей не найдено!", "Ошибка");
            return back();
        }

        $path = $this->exportFunction($u);

        return response()->download($path);

    }

    public function exportUsersAll()
    {
        $users = User::all();

        if(!isset($users)){
            Toastr::error("Таблицы результатов не существует!", "Ошибка");
            return back();
        }

        $path = $this->exportFunction($users);

        return response()->download($path);

    }

    protected function exportFunction($users)
    {
        $result = [];
        $dt = $this->gen_uuid();

        if(!file_exists(storage_path('app/csv/'))){
            mkdir(storage_path('app/csv/'));
        }
        $file = fopen(storage_path('app/csv/')."export_users_" . $dt . ".csv", 'w');
        $file_path = storage_path('app/csv/')."export_users_" . $dt . ".csv";
        fputcsv($file, [
            $this->icv('ID'),
            $this->icv('Имя'),
            $this->icv('Фамилия'),
            $this->icv('Права'),
            $this->icv('E-mail'),
            $this->icv('Баланс'),
            $this->icv('Страна'),
            $this->icv('Регион'),
            $this->icv('Город'),
            $this->icv('Дата регистрации'),
            $this->icv('Дата рождения'),
        ], ";");

        foreach ($users as $user){
            fputcsv($file, [
                $user->id,
                $this->icv($user->name),
                $this->icv($user->second_name),
                $this->icv($user->role->title),
                $this->icv($user->email),
                $this->icv($user->balance),
                $this->icv($user->country->first()->title),
                $this->icv($user->region->first()->title),
                $this->icv($user->city->first()->title),
                $this->icv($user->created_at),
                $this->icv($user->date_birth),
            ], ";");
        }

        fclose($file);

        return $file_path;
    }

    private function icv($str)
    {
        $res = "=\"" . iconv("UTF-8", "Windows-1251//IGNORE", $str) . "\"";
        return $res;
    }

    public function create()
    {

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'date_birth' => 'required|date',
            'country' => 'integer',
        ]);


        return User::create([
            'name' => $request['name'],
            'second_name' => $request['second_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'date_birth' => Carbon::parse($request['date_birth']),
            'country_id'=>$request['country'],
            'region_id'=>1,
            'city_id'=>1,
        ]);
        return redirect()->back();
    }

    public function edit($id)
    {

        switch (Lang::getLocale()) {
            case "ua":
                $lang_id=1;
                break;
            case "ru":
                $lang_id=2;
                break;
            case "en":
                $lang_id=3;
                break;
        }
        $user = User::whereId($id)->first();

        if (!isset($user)) {

            return redirect(rounte('admin.users.index'));
        }
        $countries = Country::where(['lang_id'=> $lang_id])->orderBy('country_id')->limit(300)->get();
        $regions = Region::where(['country_id'=>$user->country_id])->get();
        $cities = City::where(['country_id'=>$user->country_id, 'region_id'=>$user->region_id ])->get();
        $roles= Role::get();
          return view('admin.users.edit')->with([
              'user'=>$user,
              'countries'=>$countries,
              'regions' => $regions,
              'cities' => $cities,
              'roles' =>$roles,
          ]);
    }

    public function update(Request $request, $id)
    {
        $user=User::whereId($id)->first();
        $user->participant->setPrimKey('participant_id');
        $user->participant->firstname= $request['name'];
        $user->participant->lastname = $request['second_name'];
        $user->participant->email = $request['email'];

        $user->participant->modified =Carbon::now(config('app.timezone'));

        $user->participant->save();



        $user->role_id=($request['role']!='null') ? $request['role'] : $user->role_id;
        $user->name = $request['name'];
        $user->second_name = $request['second_name'];
        $user->email = $request['email'];
        $user->balance = $request['balance'];
        $user->rating = $request['rating'];

        $user->date_birth = Carbon::parse($request['date_birth']);
        $user->country_id=$request['country'];
        $user->region_id=($request['region']!='undefined') ? $request['region'] : null;
        $user->region_id=($request['region']!='undefined') ? $request['region'] : null;
        $user->city_id=($request['city']!='undefined') ? $request['city'] : null;
        $user->save();





        return redirect(route('admin.users.index'));
    }

    public function show($id)
    {
        $user=User::whereId($id)->first();
        if(!isset($user))return redirect('admin.users.index');

          return view('admin.users.show')->with([
              'user' =>$user,
          ]);

    }

    public function showByPid($pid)
    {
        $user=User::where(['ls_participant_id' => $pid])->first();
        if(!isset($user))return redirect('admin.users.index');

        return redirect(route('admin.users.show', ['user' => $user->id]));

    }

    public function delete($id)
    {
        try {
            User::whereId($id)->delete();
        }catch(\Exception $ex){
            return redirect('admin.paymentstype.index');
        }


        return back()->with(['message' => 'deleted']);
    }

    public function export()
    {
        $guid = Input::get('scgid');
        $forms_count = Input::get('forms_count');

        $surveys = LimeSurveys::all();

        if(config('app.locale')=='ru'){
            $countries_list = Country::where(['lang_id'=>2])->orderBy('title', 'asc')->limit(300)->get();
        }
        if(config('app.locale')=='ua'){
            $countries_list = Country::where(['lang_id'=>1])->orderBy('title', 'asc')->limit(300)->get();
        }

        if(isset($guid)){

            $in_db = SearchCache::where('guid', $guid)->first();

            if(!isset($in_db)) {
                Toastr::error("Такой страницы не существует!", "Ошибка!");
            }

            $data = json_decode($in_db->parameters, true);

            $forms = [];

            for ($i = 1; $i <= $forms_count; $i++) {

                $tmp = [];

                $tmp["type_search"] = $data["type_search_" . $i];

                if (isset($data["country_" . $i])) {
                    $tmp["country"] = $data["country_" . $i];
                }
                if (isset($data["region_" . $i])) {
                    $tmp["region"] = $data["region_" . $i];
                    $tmp["region_select"] = DB::table('regions')->select('region_id', 'title')
                        ->where('country_id', '=', $data["country_" . $i])
                        ->orderBy('title', 'asc')
                        ->get();
                }
                if (isset($data['city_' . $i])) {
                    $tmp["city"] = $data["city_" . $i];
                    $tmp["city_select"] = DB::table('cities')->select('city_id', 'title', 'area')
                        ->where($data["region_" . $i])
                        ->groupBy('title')
                        ->orderBy('title', 'asc')
                        ->get();
                }
                if (isset($data['gender_' . $i])) {
                    $tmp["gender"] = $data["gender_" . $i];
                }
                if (isset($data["age_from_" . $i]) && !empty($data['age_from_' . $i])) {
                    $tmp["age_from"] = $data["age_from_" . $i];
                }
                if (isset($data["age_to_" . $i]) && !empty($data['age_to_' . $i])) {
                    $tmp["age_to"] = $data["age_to_" . $i];
                }


                if (isset($data['type_' . $i])) {
                    $tmp["type"] = $data["type_" . $i];
                }
                if (isset($data['questions_' . $i])) {
                    $tmp["questions"] = $data["questions_" . $i];
                    $survey = LimeSurveys::where(['sid' => $data["type_" . $i]])->first();
                    $tmp["questions_select"] = $survey->questions;
                }
                if (isset($data['answers_' . $i])) {
                    $tmp["answers"] = $data["answers_" . $i];
                    $question = LimeSurveysQuestions::where(['qid' => $data["questions_" . $i]])->first();
                    $tmp["answers_select"] = $question->answers;
                }
                if (isset($data['gid_' . $i])) {
                    $tmp["gid"] = $data["gid_" . $i];
                }
                $forms[] = $tmp;
            }


            $users = DB::table('search_cache_' .$guid)->paginate(20);
            $users_count = DB::table('search_cache_' .$guid)->count();

            return view('admin.users.export', with([
                'surveys' => $surveys,
                'users' => $users,
                'guid' => $guid,
                'forms' => $forms,
                'forms_count' => $forms_count,
                'users_count' => $users_count,
                'countries' => isset($countries_list) ? $countries_list : []
            ]));
        }



        return view('admin.users.export', with([
            'surveys' => isset($surveys) ? $surveys : [],
            'countries' => isset($countries_list) ? $countries_list : []
        ]));
    }

    public function findIndex(Request $request)
    {
        $guid = Input::get('scgid');
        $forms_count = Input::get('forms_count');

        $data = $request->all();
        if(!isset($data) || count($data) < 3){
            Toastr::error("Не указаны параметры поиска", "Ошибка!");
            return back();
        }

        $surveys = LimeSurveys::all();

        if(config('app.locale')=='ru'){
            $countries_list = Country::where(['lang_id'=>2])->orderBy('title', 'asc')->limit(300)->get();
        }
        if(config('app.locale')=='ua'){
            $countries_list = Country::where(['lang_id'=>1])->orderBy('title', 'asc')->limit(300)->get();
        }

        array_shift($data);
        $count = array_shift($data);

        $in_db = SearchCache::where('parameters', json_encode($data))->first();

        if(!isset($in_db)) {
            $guid = $this->gen_uuid();
            $search_cache = new SearchCache();
            $search_cache->parameters = json_encode($data);
            $search_cache->guid = $guid;
            $search_cache->search_time = Carbon::now();
            $search_cache->save();

            Schema::connection('mysql')->create('search_cache_' . $guid, function ($table) {
                $table->increments('id');
                $table->string('participant_id', 50)->nullable();
                $table->string('firstname', 150)->nullable();
                $table->string('lastname', 150)->nullable();
            });

            $search_result = $this->findUsers($data, $count);

            DB::table('search_cache_' . $guid)->insert($search_result);
        }else{
            $guid = $in_db->guid;
        }

        $forms = [];

        for ($i = 1; $i <= $count; $i++) {

            $tmp = [];

            $tmp["type_search"] = $data["type_search_" . $i];

            if (isset($data["country_" . $i])) {
                $tmp["country"] = $data["country_" . $i];
            }
            if (isset($data["region_" . $i])) {
                $tmp["region"] = $data["region_" . $i];
                $tmp["region_select"] = DB::table('regions')->select('region_id', 'title')
                    ->where('country_id', '=', $data["country_" . $i])
                    ->orderBy('title', 'asc')
                    ->get();
            }
            if (isset($data['city_' . $i])) {
                $tmp["city"] = $data["city_" . $i];
                $tmp["city_select"] = DB::table('cities')->select('city_id', 'title', 'area')
                    ->where($data["region_" . $i])
                    ->groupBy('title')
                    ->orderBy('title', 'asc')
                    ->get();
            }
            if (isset($data['gender_' . $i])) {
                $tmp["gender"] = $data["gender_" . $i];
            }
            if (isset($data["age_from_" . $i]) && !empty($data['age_from_' . $i])) {
                $tmp["age_from"] = $data["age_from_" . $i];
            }
            if (isset($data["age_to_" . $i]) && !empty($data['age_to_' . $i])) {
                $tmp["age_to"] = $data["age_to_" . $i];
            }


            if (isset($data['type_' . $i])) {
                $tmp["type"] = $data["type_" . $i];
            }
            if (isset($data['questions_' . $i])) {
                $tmp["questions"] = $data["questions_" . $i];
                $survey = LimeSurveys::where(['sid' => $data["type_" . $i]])->first();
                $tmp["questions_select"] = $survey->questions;
            }
            if (isset($data['answers_' . $i])) {
                $tmp["answers"] = $data["answers_" . $i];
                $question = LimeSurveysQuestions::where(['qid' => $data["questions_" . $i]])->first();
                $tmp["answers_select"] = $question->answers;
            }
            if (isset($data['gid_' . $i])) {
                $tmp["gid"] = $data["gid_" . $i];
            }
            $forms[] = $tmp;
        }

        $users = DB::table('search_cache_' .$guid)->paginate(20);
        $users_count = DB::table('search_cache_' .$guid)->count();

        return view('admin.users.export', [
            'surveys' => $surveys,
            'users' => $users,
            'guid' => $guid,
            'forms' => $forms,
            'forms_count' => $count,
            'users_count' => $users_count,
            'countries' => isset($countries_list) ? $countries_list : []
        ]);

    }

    static function findUsers($data, $count)
    {
        if (!isset($data) || !isset($count)) {
            return false;
        }
        $lime_base = DB::connection('mysql_lime');

        $result_arr = [];

        for ($i = 1; $i <= $count; $i++) {
            $search_type = $data["type_search_" . $i];

            if ($search_type == 1) {
                $userWhere = [];
                if (isset($data["country_" . $i])) {
                    $userWhere[] = ['country_id', '=', $data["country_" . $i]];
                }
                if (isset($data["region_" . $i])) {
                    $userWhere[] = ['region_id', '=', $data["region_" . $i]];
                }
                if (isset($data['city_' . $i])) {
                    $userWhere[] = ['city_id', '=', $data["city_" . $i]];
                }
                if (isset($data['gender_' . $i])) {
                    $userWhere[] = ['gender', '=', $data["gender_" . $i]];
                }
                if (isset($data["age_from_" . $i]) && !empty($data['age_from_' . $i])) {
                    $userWhere[] = ['date_birth', '>', Carbon::now()->subYears($data["age_from_" . $i])->format("Y-m-d")];
                }
                if (isset($data["age_to_" . $i]) && !empty($data['age_to_' . $i])) {
                    $userWhere[] = ['date_birth', '<', Carbon::now()->subYears($data["age_to_" . $i])->format("Y-m-d")];
                }

                $users = User::where($userWhere)->whereNotNull('ls_participant_id')->select(DB::raw('name as firstname, second_name as lastname, ls_participant_id as participant_id'))
                    ->get(["firstname", "lastname", "participant_id"])->toArray();

                if (!isset($users)) {
                    continue;
                }

                if ($i == 1) {
                    $result_arr = $users;
                } else {
                    $now = array_column($result_arr, 'participant_id');
                    $delete = array_column($users, 'participant_id');

                    $tmp = [];
                    foreach (array_intersect($now, $delete) as $key => $item) {
                        $tmp[] = $result_arr[$key];
                    }
                    $result_arr = $tmp;
                }

            } else {
                $type = $data["type_" . $i];
                $questions = $data["questions_" . $i];
                $answers = $data["answers_" . $i];
                $gid = $data["gid_" . $i];
                if (!isset($type) || !isset($questions) || !isset($answers) || !isset($gid)) {
                    return false;
                }
                $users = $lime_base->table('survey_' . $type)
                    ->join('tokens_' . $type, 'tokens_' . $type . '.token', '=', 'survey_' . $type . '.token')
                    ->where('survey_' . $type . '.' . $type . "X" . $gid . "X" . $questions, '=', $answers)->select(['tokens_' . $type . '.firstname', 'tokens_' . $type . '.lastname', 'tokens_' . $type . '.participant_id'])
                    ->get();
                $users = collect($users)->map(function ($x) {
                    return (array)$x;
                })->toArray();


                if ($i == 1) {
                    $result_arr = $users;
                } else {
                    $now = array_column($result_arr, 'participant_id');
                    $delete = array_column($users, 'participant_id');

                    $tmp = [];
                    foreach (array_intersect($now, $delete) as $key => $item) {
                        $tmp[] = $result_arr[$key];
                    }
                    $result_arr = $tmp;
                }

            }
        }

        return $result_arr;
    }

    static function gen_uuid()
    {
        return sprintf(
            '%04x%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000
        );
    }
}
