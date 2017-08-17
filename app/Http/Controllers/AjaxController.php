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
use App\User;
use Carbon\Carbon;

class AjaxController extends Controller
{
    //
    public function getRegionsInfo($countryid)
    {
        $regions = DB::table('regions')->select('region_id', 'title')->where('country_id', '=', $countryid)->orderBy('title', 'asc')->get();
        return Response::json($regions);
    }

    public function getCitiesInfo($countryid, Request $request)
    {
        $req_arr = [];
        if (isset($request["region_id"])) {
            $req_arr ['region_id'] = $request["region_id"];
        }
        $req_arr  ['country_id'] = $countryid;
        $cities = DB::table('cities')->select('city_id', 'title','area')->where($req_arr)->groupBy('title')->orderBy('title', 'asc')->get();
        return Response::json($cities);
    }

    public function updatebalance($id, Request $request)
    {

        if (Auth::user() != null) {

            if (Auth::user()->participant->checkCompleteSurvey($id)) {
                $balance_transacrion = Auth::user()->balancetransactionlog()->where(['ls_surveys_id' => $id])->first();

                if (!isset($balance_transacrion)) {
                    $limesurvey = LimeSurveys::where(['sid' => $id])->first();
                    $text = $limesurvey->type_id == 0 ? Lang::get('messages.CompleteProfilesBalanceLog') : Lang::get('messages.CompleteSurveysBalanceLog');

                    if (isset($limesurvey)) {
                        Auth::user()->increment('balance', $limesurvey->reward);

                        BalanceTransactionLog::create([


                            'to_user_id' => Auth::user()->id,
                            'from_user_id' => 0,
                            'description' => $text,
                            'balance_operation' => $limesurvey->reward,
                            'status' => 1,
                            'payment_type_id' => 0,
                            'ls_surveys_id' => $id,

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

        if (!isset($survey)) {
            return json_encode(["data" => "error"]);
        }

        $questions = $survey->questions;

        return json_encode($questions);
    }

    public function getSurveyQuestionsAnswers(Request $request)
    {
        $question_id = $request->get("qid");
        $question = LimeSurveysQuestions::where(['qid' => $question_id])->first();

        if (!isset($question)) {
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

        $participants = $lime_base->table('survey_' . $sid)->where([$sid . "X" . $gid . "X" . $qid => $aid])->get();
        return json_encode($participants);
    }

    public function getListParticipants(Request $request)
    {
        $count = $request->get('count');
        $data = $this->unserializeForm($request->get('data'));

        if (!isset($data) || !isset($count)) {
            return json_encode("error");
        }
        $lime_base = DB::connection('mysql_lime');

        $result_arr = [];

        for ($i = 1; $i <= $count; $i++) {
            $search_type = $data["type_search_" . $i];

            if ($search_type == 1) {
                $country = $data["country_" . $i];
                $region = $data["region_" . $i];
                $city = $data["city_" . $i];
                $gender = $data["gender_" . $i];
                $age_from = $data["age_from_" . $i];
                $age_to = $data["age_to_" . $i];

                $dt = Carbon::now();
                $age1 = Carbon::now()->subYears($age_from)->format("Y-m-d");
                $age2 = Carbon::now()->subYears($age_to)->format("Y-m-d");

                $users = User::where([
                    'country_id' => $country,
                    'region_id' => $region,
                    'city_id' => $city,
                    'gender' => $gender
                ])
                    ->whereBetween('date_birth', [$age2, $age1])
                    ->get();

                if (!isset($users)) {
                    return json_encode("error");
                }

                $users_array = [];
                foreach ($users as $user) {
                    $users_array[] = [
                        "firstname" => $user->name,
                        "lastname" => $user->second_name,
                        "participant_id" => $user->ls_participant_id
                    ];
                }

            } else {
                $type = $data["type_" . $i];
                $questions = $data["questions_" . $i];
                $answers = $data["answers_" . $i];
                $gid = $data["gid_" . $i];
                if (!isset($type) || !isset($questions) || !isset($answers) || !isset($gid)) {
                    return json_encode("error");
                }
                $tmp = $lime_base->table('survey_' . $type)->where($type . "X" . $gid . "X" . $questions, '=', $answers)->get();
                $tmp_arr = [];
                foreach ($tmp as $t) {
                    $tmp_arr[] = [
                        "survey_id" => $type,
                        "token" => $t->token
                    ];
                }
                $result_arr = $this->unique_multidim_array((array_merge($result_arr, $tmp_arr)), 'token');
            }


        }

        $result = $this->findParticipantBySidTid($result_arr);
        return json_encode($this->unique_multidim_array((array_merge($result, $users_array)), 'participant_id'));
    }

    protected function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    protected function findParticipantBySidTid($data)
    {
        $res = [];
        $lime_base = DB::connection('mysql_lime');
        foreach ($data as $dt) {
            $f = $lime_base->table('tokens_' . $dt["survey_id"])->where(['token' => $dt["token"]])->first();
            if (!isset($f)) {
                continue;
            }
            $res[] = [
                "firstname" => $f->firstname,
                "lastname" => $f->lastname,
                "participant_id" => $f->participant_id
            ];
        }
        return $res;
    }

    protected function findParticipantId($sid, $arr)
    {
        $res = [];
        $lime_base = DB::connection('mysql_lime');
        foreach ($arr as $item) {
            $f = $lime_base->table('tokens_' . $sid)->where(['token' => $item->token])->first();
            $res[] = $f->participant_id;
        }
        return $res;
    }

    public function getCountParticipants($survey_id)
    {
        $lime_base = DB::connection('mysql_lime');
        $count = $lime_base->table('tokens_' . $survey_id)->distinct('participant_id')->count('participant_id');

        if (!isset($count)) {
            return json_encode("error");
        }

        return json_encode($count);
        return $count;
    }

    public function getQuotes($survey_id)
    {
        $survey = LimeSurveys::where(['sid' => $survey_id])->first();

        if (!isset($survey)) {
            return json_encode("error");
        }

        $quotes = $survey->getQuotes;

        if (!isset($quotes) || count($quotes) == 0) {
            return json_encode("error");
        }
        return json_encode($quotes);
    }

    protected function unserializeForm($str)
    {
        $strArray = explode("&", $str);
        foreach ($strArray as $item) {
            $array = explode("=", $item);
            $returndata[$array[0]] = $array[1];
        }
        return $returndata;
    }
}
