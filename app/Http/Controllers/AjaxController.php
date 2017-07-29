<?php

namespace App\Http\Controllers;

use App\Models\BalanceTransactionLog;
use App\Models\Lime\LimeSurveys;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use App\Models\Lime\LimeSurveysQuestions;
use App\Models\Lime\LimeSurveysQuestionsAnswers;

class AjaxController extends Controller
{
    //
    public function getRegionsInfo($countryid){


            $regions = DB::table('regions')->select('region_id','title')->where('country_id', '=', $countryid)->get();
            return Response::json( $regions );


    }
    public function getCitiesInfo($countryid,Request $request){

        $req_arr =[];
        if(isset($request["region_id"])){
           $req_arr ['region_id'] = $request["region_id"];
        }

        $req_arr  ['country_id'] =$countryid;

        $cities = DB::table('cities')->select('city_id','title','area')->where($req_arr)->get();
        return Response::json( $cities );


    }
    public function updatebalance($id,Request $request){

       if(Auth::user()!=null){

           if(Auth::user()->participant->checkCompleteSurvey($id)){
            $balance_transacrion= Auth::user()->balancetransactionlog()->where(['ls_surveys_id'=>$id])->first();

            if(!isset($balance_transacrion)){
                $limesurvey= LimeSurveys::where(['sid'=>$id])->first();
                $text = $limesurvey->type_id==0 ? Lang::get('messages.CompleteProfilesBalanceLog'):Lang::get('messages.CompleteSurveysBalanceLog');

                if(isset($limesurvey)) {
                    Auth::user()->increment('balance',$limesurvey->reward);

                    BalanceTransactionLog::create([


                            'to_user_id' =>Auth::user()->id,
                            'from_user_id'=> 0,
                            'description' => $text,
                            'balance_operation'=>$limesurvey->reward,
                            'status'=> 1,
                            'payment_type_id'=>0,
                            'ls_surveys_id'=>$id,

                    ]);



                }
            }
           }


       }
        return redirect(route('site.index'));
    }

    public function getSurveyQuestions(Request $request)
    {
        $survey_id = $request->get("sid");

        $survey = LimeSurveys::where(['sid' => $survey_id])->first();

        if(!isset($survey)){
            return json_encode(["data" => "error"]);
        }

        $questions = $survey->questions;

        return json_encode($questions);
    }

    public function getSurveyQuestionsAnswers(Request $request)
    {
        $question_id = $request->get("qid");
        $question = LimeSurveysQuestions::where(['qid' => $question_id])->first();

        if(!isset($question)){
            return json_encode(["data" => "error"]);
        }

        $answers = $question->answers;
        return json_encode(["data" => $answers, "gid" => $question->gid]);
    }

    public function getSurveyParticipants(Request $request)
    {
        $aid = $request->get("aid");
        $qid = $request->get("qid");
        $sid = $request->get("sid");
        $gid = $request->get("gid");

        $lime_base = DB::connection('mysql_lime');

        $participants = $lime_base->table('survey_'.$sid)->where([$sid."X".$gid."X".$qid => $aid])->get();
        return json_encode($participants);
    }

    public function getListParticipants(Request $request)
    {
        $count = $request->get('count');
        $data = $this->unserializeForm($request->get('data'));

        $type = $data["type_1"];
        $questions = $data["questions_1"];
        $answers = $data["answers_1"];
        $question_condition = $data["question_condition_1"];

        $condition = $question_condition == 0 ? '<>' : '=';

        $lime_base = DB::connection('mysql_lime');
        $gid = $lime_base->table('questions')->where(['qid' => $questions])->first();
        $result = $lime_base->table('survey_'.$type)->where($type."X".$gid->gid."X".$questions, $condition, $answers)->get();

        return json_encode($this->findParticipantId($type, $result));
    }

    protected function findParticipantId($sid, $arr)
    {
        $res = [];
        $lime_base = DB::connection('mysql_lime');
        foreach ($arr as $item){
            $f = $lime_base->table('tokens_'.$sid)->where(['token' => $item->token])->first();
            $res[] = $f->participant_id;
        }
        return $res;
    }

    protected function unserializeForm($str) {
        $strArray = explode("&", $str);
        foreach($strArray as $item) {
            $array = explode("=", $item);
            $returndata[$array[0]] = $array[1];
        }
        return $returndata;
    }
}
