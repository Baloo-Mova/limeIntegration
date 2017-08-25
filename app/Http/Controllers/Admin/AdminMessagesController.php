<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendMessage;
use App\Helpers\Macros;
use PHPMailer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Input;
use App\Models\Country;
use App\Models\Lime\LimeSurveys;
use App\Models\SearchCache;
use Illuminate\Support\Facades\DB;
use App\Models\Lime\LimeSurveysQuestions;
use App\Models\Lime\LimeSurveysQuestionsAnswers;
use App\Jobs\SendBaseJob;

class AdminMessagesController extends Controller
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

            return view('admin.messages.index', with([
                'surveys' => $surveys,
                'users' => $users,
                'guid' => $guid,
                'forms' => $forms,
                'forms_count' => $forms_count,
                'users_count' => $users_count,
                'countries' => isset($countries_list) ? $countries_list : []
            ]));
        }



        return view('admin.messages.index', with([
            'surveys' => isset($surveys) ? $surveys : [],
            'countries' => isset($countries_list) ? $countries_list : []
        ]));
    }

    public function sendMessageByPids(Request $request)
    {
        $send_all = $request->get('send_all');
        $guid = $request->get('guid');
        $text = $request->get('text');

        if(!isset($text)){
            Toastr::error("Отсутствуют обязательные параметры!", "Ошибка!");
            return back();
        }
        $this->dispatch(new SendBaseJob($guid, isset($send_all) ? true : false, $text));

        Toastr::success('Сообщения разосланы!', 'Успешно!');
        return back();

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

        return view('admin.messages.index', [
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


    public function createMessage()
    {
        $users = User::all();
        return view('admin.messages.create', with([
            'users' => $users
        ]));
    }

    public function sendBaseMessage(Request $request)
    {
        $text = $request->get('text');
        $users = $request->get('user');
        $send_all = $request->get('send_all');

        if(!isset($text)){
            return back();
        }

        if($send_all == "on"){
            $users = User::all();
            if(!isset($users)) {
                Toastr::error('Сообщение не отправлено!', 'Ошибка');
                return back();
            }
            foreach ($users as $user){
                if($user->role_id == 2){
                    continue;
                }
                $user->notify(new SendMessage($text));
            }
        }else{
            foreach ($users as $user){
                $u = User::find($user);
                if(!isset($u)) {
                    Toastr::error('Сообщение не отправлено!', 'Ошибка');
                    return back();
                }
                $u->notify(new SendMessage($text));
            }
        }

        Toastr::success('Сообщение успешно отправлено!', 'Отправлено');
        return back();

    }

    public function sendBaseMessageToList(Request $request)
    {
        $text = $request->get('text');
        $users = $request->get('participant');

        if(!isset($users) || !isset($text)){
            Toastr::error('Сообщение не отправлено!', 'Ошибка');
            return back();
        }
        foreach ($users as $user){
            $u = User::where(['ls_participant_id' => $user])->first();
            if(!isset($u)) {
                Toastr::error('Сообщение не отправлено!', 'Ошибка');
                return back();
            }
            $u->notify(new SendMessage($text));
        }
        Toastr::success('Сообщение успешно отправлено!', 'Отправлено');
        return back();
    }

    public function createEmailMessage()
    {
        $users = User::all();
        return view('admin.messages.email', with([
            'users' => $users
        ]));
    }

    public function sendEmailMessage(Request $request)
    {
        $user_email = $request->get('user');
        $text_tmp = $request->get('text');
        $smtp = $request->get('smtp');
        $port = $request->get('port');
        $login = $request->get('login');
        $pasw = $request->get('pasw');

        if(!isset($user_email)){
            return back();
        }
        if(!isset($text_tmp)){
            return back();
        }else{
            $text = Macros::convertMacro($text_tmp);
        }
        if(!isset($smtp)){
            return back();
        }
        if(!isset($port)){
            return back();
        }
        if(!isset($login)){
            return back();
        }
        if(!isset($pasw)){
            return back();
        }

        try {
            $mail = new PHPMailer;
            // $mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $smtp;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $login;                 // SMTP username
            $mail->Password = $pasw;                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $port;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            $mail->setFrom(\Auth::user()->email);
            $mail->addAddress($user_email);     // Add a recipient

            $mail->Subject = "Сообщение от админа";
            $mail->Body = $text;

            if (!$mail->send()) {
                Toastr::error('Сообщение не отправлено!', 'Ошибка');
            } else {
                Toastr::success('Сообщение успешно отправлено!', 'Отправлено');
            }
        } catch (\Exception $ex) {
            Toastr::error('Сообщение не отправлено!', 'Ошибка');
            return back();
        }

        return back();

    }
}
