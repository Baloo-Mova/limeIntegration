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

class AdminManageSurveyParticipantsController extends Controller
{
    public function index()
    {
        $surveys = LimeSurveys::where(['type_id' => 0])->get();
        return view('admin.manage.index', with([
            'surveys' => $surveys
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

        if(!isset($survey_id)){
            Toastr::error("Вы не указали опрос", "Ошибка");
            return back();
        }

        if(!isset($participants)){
            Toastr::error("Вы не указали участников опроса", "Ошибка");
            return back();
        }

        $users = explode("\r\n", $participants);

        $lime_base = DB::connection('mysql_lime');
        $schemaConnAdmin = Schema::connection('mysql_lime');

        if(!$schemaConnAdmin->hasTable('tokens_'.$survey_id)){
            $schemaConnAdmin->create('tokens_'.$survey_id, function (Blueprint $table) {
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

        foreach ($users as $user){
            $participant = $lime_base->table('tokens_'.$survey_id)->where(['participant_id' => $user])->first();

            if(isset($participant)){
                continue;
            }

            $u = LimeParticipants::where(['participant_id' => $user])->first();

            if(!isset($u)){
                continue;
            }

            $t = $lime_base->table('tokens_'.$survey_id)->insertGetId([
                'participant_id' => $user,
                'firstname' => $u->name,
                'lastname' => $u->second_name,
                'email'    => $u->email,
                'token'    => $this->gen_uuid(),
                'emailstatus' => 'OK'
            ]);
            $res[] = [
                'participant_id' => $user,
                'token_id'       => $t,
                'survey_id'      => $survey_id,
                'date_created'   => Carbon::now()->toDateTimeString()
            ];

        }

        $lime_base->table('survey_links')->insert($res);
        Toastr::success("Пользователи успешно добавлены к опросу!", "Сохранено");
        return back();

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
