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
        $cities = DB::table('cities')->select('city_id', 'title', 'area')->where($req_arr)->groupBy('title')->orderBy('title', 'asc')->get();
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
                    return json_encode("error");
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

        return json_encode($result_arr);
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
            try {
                $f = $lime_base->table('tokens_' . $dt["survey_id"])->where(['token' => $dt["token"]])->first();
            } catch (\Exception $ex) {
            }
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
            try {
                $f = $lime_base->table('tokens_' . $sid)->where(['token' => $item->token])->first();
                $res[] = $f->participant_id;
            } catch (\Exception $ex) {
            }
        }
        return $res;
    }

    public function getCountParticipants($survey_id)
    {
        $count = 0;
        try {
            $lime_base = DB::connection('mysql_lime');
            $count = $lime_base->table('tokens_' . $survey_id)->distinct('participant_id')->count('participant_id');

        } catch (\Exception $ex) {
        }
        if (!isset($count)) {
            return json_encode("error");
        }

        return json_encode($count);
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
