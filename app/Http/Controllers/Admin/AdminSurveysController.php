<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lime\LimeParticipants;
use App\Models\Lime\LimeSurveyLinks;
use App\Models\Lime\LimeSurveys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class AdminSurveysController extends Controller
{
    public function index()
    {
        $surveys = LimeSurveys::paginate(10);
        return view('admin.surveys.index', with([
            'surveys' => $surveys
        ]));
    }

    public function statistics()
    {
        $finished = LimeSurveyLinks::finished()->distinct('token_id')->count('token_id');
        $not_finished = LimeSurveyLinks::notFinished()->distinct('token_id')->count('token_id');
        $surveys = LimeSurveys::all();

        return view('admin.surveys.statistics', [
            'finished' => isset($finished) ? $finished : 0 ,
            'not_finished' => isset($not_finished) ? $not_finished : 0,
            'surveys' => isset($surveys) ? $surveys : []
        ]);
    }

    public function processing()
    {
        return view('admin.surveys.processing');
    }
    public function convertToWorksheet($sid, $type)
    {
        $survey = LimeSurveys::where(['sid' => $sid])->first();

        if(!isset($survey)){
            return back();
        }

        $lime_base = DB::connection('mysql_lime');
        $lime_base->table('surveys')->where('sid', $sid)->update(['type_id' => $type]);

        if($type == 0){
            $res = $this->addParticipantsToWorksheet($sid);
        }else{
            $res = $this->deleteParticipantsFromWorksheet($sid);
        }

        return back();
    }

    protected function addParticipantsToWorksheet($sid)
    {
        $lime_base = DB::connection('mysql_lime');
        $schemaConnAdmin = Schema::connection('mysql_lime');

        $partisipants = LimeParticipants::all();
        if(!isset($partisipants)){
            return false;
        }

        if(!$schemaConnAdmin->hasTable('tokens_'.$sid)){
            $schemaConnAdmin->create('tokens_'.$sid, function (Blueprint $table) {
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

        foreach ($partisipants as $p){
            $participant = $lime_base->table('tokens_'.$sid)->where(['participant_id' => $p->participant_id])->first();

            if(isset($participant)){
                continue;
            }

            $t = $lime_base->table('tokens_'.$sid)->insertGetId([
                'participant_id' => $p->participant_id,
                'firstname' => $p->name,
                'lastname' => $p->second_name,
                'email'    => $p->email,
                'token'    => $this->gen_uuid(),
                'emailstatus' => 'OK'
            ]);
            $res[] = [
                'participant_id' => $p->participant_id,
                'token_id'       => $t,
                'survey_id'      => $sid,
                'date_created'   => Carbon::now()->toDateTimeString()
            ];

        }

        $lime_base->table('survey_links')->insert($res);

        return true;

    }

    protected function deleteParticipantsFromWorksheet($sid)
    {
        $lime_base = DB::connection('mysql_lime');
        $schemaConnAdmin = Schema::connection('mysql_lime');

        $partisipants = LimeParticipants::all();
        if(!isset($partisipants)){
            return false;
        }

        if(!$schemaConnAdmin->hasTable('tokens_'.$sid)){
            return true;
        }

        foreach ($partisipants as $p){
            $participant = $lime_base->table('tokens_'.$sid)->where(['participant_id' => $p->participant_id])->first();
            if(!isset($participant)){
                continue;
            }
            $lime_base->table('survey_links')->where([
                'participant_id' => $p->participant_id,
                'token_id'       => $participant->tid,
                'survey_id'      => $sid
            ])->delete();
            $lime_base->table('tokens_'.$sid)->where(['participant_id' => $p->participant_id])->delete();
        }

        return true;

    }

    protected function gen_uuid()
    {
        return sprintf(
            '%04x%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000
        );
    }

    public function changeReward(Request $request)
    {
        $sid = $request->get('sid');
        $money = $request->get('money');

        if(!isset($sid) || !isset($money)){
            Toastr::error('Не указан обязательный параметр!', 'Ошибка');
            return back();
        }

        $survey = LimeSurveys::where(['sid' => $sid])->first();

        if(!isset($survey)){
            Toastr::error('Опрос не найден!', 'Ошибка');
            return back();
        }

        $lime_base = DB::connection('mysql_lime');
        $lime_base->table('surveys')->where('sid', $sid)->update(['reward' => $money]);

        Toastr::success('Сумма вознаграждения изменена', 'Сохранено!');
        return back();
    }
}
