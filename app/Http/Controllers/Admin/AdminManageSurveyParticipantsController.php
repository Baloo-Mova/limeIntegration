<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lime\LimeParticipants;
use App\Models\Lime\LimeSurveys;
use App\Models\SearchCache;
use App\Models\Surveys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Notifications\UserNotification;
use App\User;
use App\Models\Country;
use App\Models\Settings;
use App\Jobs\SendJob;
use App\Models\Lime\LimeSurveysQuestions;
use Illuminate\Support\Facades\Session;

class AdminManageSurveyParticipantsController extends Controller
{
    public function index()
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

            return view('admin.manage.index', with([
                'surveys' => $surveys,
                'users' => $users,
                'guid' => $guid,
                'forms' => $forms,
                'forms_count' => $forms_count,
                'users_count' => $users_count,
                'countries' => isset($countries_list) ? $countries_list : []
            ]));
        }



        return view('admin.manage.index', with([
            'surveys' => isset($surveys) ? $surveys : [],
            'countries' => isset($countries_list) ? $countries_list : []
        ]));
    }

    public function addParticipant()
    {
        $surveys = LimeSurveys::all();
        return view('admin.manage.addParticipant', with([
            'surveys' => $surveys
        ]));
    }

    public function saveParticipant(Request $request)
    {
        $survey_id = $request->get('survey');
        $participants = $request->get('participants');

        if (!isset($survey_id)) {
            Toastr::error("Вы не указали опрос", "Ошибка");
            return back();
        }

        if (!isset($participants)) {
            Toastr::error("Вы не указали участников опроса", "Ошибка");
            return back();
        }

        $users = explode("\r\n", $participants);

        if ($this->addParticipantsToDb($survey_id, $users)) {
            Toastr::success("Пользователи успешно добавлены к опросу!", "Сохранено");
            return back();
        } else {
            Toastr::error("Ошибка!", "Ошибка");
            return back();
        }
    }

    public function addListParticipants(Request $request)
    {
        $survey_id = $request->get('survey');
        $guid = $request->get('guid');

        $participants = DB::table('search_cache_' .$guid)->get()->toArray();

        if (!isset($survey_id)) {
            Toastr::error("Вы не указали опрос", "Ошибка");
            return back();
        }

        if (!isset($participants)) {
            Toastr::error("Вы не указали участников опроса", "Ошибка");
            return back();
        }

        $participants = collect($participants)->map(function ($x) {
            return (array)$x;
        })->toArray();

        if ($this->addParticipantsToDb($survey_id, array_column($participants, 'participant_id'))) {
            Toastr::success("Пользователи успешно добавлены к опросу!", "Сохранено");
            return back();
        } else {
            Toastr::error("Ошибка!", "Ошибка");
            return back();
        }
    }

    protected function addParticipantsToDb($survey_id, $participants)
    {
        $lime_base = DB::connection('mysql_lime');
        $schemaConnAdmin = Schema::connection('mysql_lime');

        if (!$schemaConnAdmin->hasTable('tokens_' . $survey_id)) {
            $schemaConnAdmin->create('tokens_' . $survey_id, function (Blueprint $table) {
                $table->increments('tid');
                $table->string('participant_id', 50)->nullable();
                $table->string('firstname', 150)->nullable();
                $table->string('lastname', 150)->nullable();
                $table->text('email')->nullable()->nullable();
                $table->text('emailstatus')->nullable();
                $table->string('token', 35)->nullable();
                $table->string('language', 25)->nullable();
                $table->string('blacklisted', 17)->nullable();
                $table->string('sent', 17)->default('N');
                $table->string('remindersent', 17)->default('N');
                $table->integer('remindercount')->default(0);
                $table->string('completed', 17)->default('N');
                $table->integer('usesleft')->default(1);
                $table->datetime('validfrom')->nullable();
                $table->datetime('validuntil')->nullable();
                $table->integer('mpid')->nullable();
            });
        }

        $res = [];

        foreach ($participants as $user) {
            $participant = $lime_base->table('tokens_' . $survey_id)->where(['participant_id' => $user])->first();

            if (isset($participant)) {
                continue;
            }

            $u = LimeParticipants::where(['participant_id' => $user])->first();

            if (!isset($u)) {
                continue;
            }
            $t = $lime_base->table('tokens_' . $survey_id)->insertGetId([
                'participant_id' => $user,
                'firstname' => $u->firstname,
                'lastname' => $u->lastname,
                'email' => $u->email,
                'token' => $this->gen_uuid(),
                'emailstatus' => 'OK'
            ]);
            $lime_base->table('survey_links')->insert([
                'participant_id' => $user,
                'token_id' => $t,
                'survey_id' => $survey_id,
                'date_created' => Carbon::now()->toDateTimeString()
            ]);

            $user_for_notificate = User::where('ls_participant_id', $user)->first();
            if (!isset($user_for_notificate)) {
                continue;
            }
            $token = $lime_base->table('tokens_' . $survey_id)->where('tid', $t)->first();
            if (!isset($token)) {
                continue;
            }
        }

        dispatch(new SendJob([
            'type' => "new_survey",
            'survey_id' => $survey_id
        ], $participants));

        return true;
    }

    /*
     *
     */
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

        return view('admin.manage.index', [
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
