<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lime\LimeParticipants;
use App\Models\Lime\LimeSurveys;
use App\Models\Surveys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Notifications\UserNotification;
use App\User;
use App\Models\Country;
use App\Models\Settings;
use App\Jobs\SendJob;

class AdminManageSurveyParticipantsController extends Controller
{
    public function index()
    {
        $worksheets = LimeSurveys::where(['type_id' => 0])->get();
        $surveys = LimeSurveys::where(['type_id' => 1])->get();
        $countries_list = Country::orderBy('title', 'asc')->limit(300)->get();
        return view('admin.manage.index', with([
            'surveys' => $surveys,
            'worksheets' => $worksheets,
            'countries' => $countries_list
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
        $participants = $request->get('participant');

        if (!isset($survey_id)) {
            Toastr::error("Вы не указали опрос", "Ошибка");
            return back();
        }

        if (!isset($participants)) {
            Toastr::error("Вы не указали участников опроса", "Ошибка");
            return back();
        }

        if ($this->addParticipantsToDb($survey_id, $participants)) {
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
            $url = "/gotosurvey/" . $survey_id . "/" . $token->token;
            $message = [
                'type' => "new_survey",
                'name' => $user_for_notificate->name,
                'surname' => $user_for_notificate->second_name,
                'email' => $user_for_notificate->email,
                'url' => url($url),
                'button' => "Вы можете пройти его по <a href='" . url($url) . "'>этой ссылке</a>",
            ];
            dispatch(new SendJob($message));


        }

        return true;
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
