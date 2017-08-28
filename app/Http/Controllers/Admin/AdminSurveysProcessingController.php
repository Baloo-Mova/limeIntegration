<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Lime\LimeParticipants;
use App\Models\Lime\LimeSurveyLinks;
use App\Models\Lime\LimeSurveysLanguageSettings;
use App\Models\Lime\LimeSurveysQuestions;
use App\Models\Lime\LimeSurveysQuestionsAnswers;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use App\Models\Lime\LimeSurveys;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AdminSurveysProcessingController extends Controller
{
    public function index()
    {
        $surveys = LimeSurveys::where(['type_id' => 0])->get();
        return view('admin.processing.index', [
            'surveys' => $surveys
        ]);
    }

    public function getUsers(Request $request)
    {
        $users = LimeParticipants::select(['participant_id', 'email','firstname','lastname'])
            ->where('email', 'like', '%' . $request->email['term'] . '%')
            ->orWhere('firstname', 'like', '%' . $request->email['term'] . '%')
            ->orWhere('lastname', 'like', '%' . $request->email['term'] . '%')
            ->offset($request->page == null ? 0 : $request->page * 10)
            ->limit(10)
            ->get();

        $response = [];
        foreach ($users as $item) {
            $response[] = [
                'id' => $item->participant_id,
                'text' => $item->email . " ( ".$item->firstname." ".$item->lastname." )"
            ];
        }

        return response()->json($response);
    }

    public function finishedWorksheets(Request $request)
    {
        $daterange = $request->get('date');
        if (isset($daterange)) {
            $find = stripos($daterange, ' -');
            $date_from = substr($daterange, 0, $find);
            $date_to = substr($daterange, $find + 3);
        }

        $user = $request->get('user');
        $surveys = $request->get('surveys');
        $type_survey = $request->get('type_survey');

        $user = User::where('ls_participant_id', '=', $user)->first();
        if (!isset($user)) {
            Toastr::error('Пользователь не найден');
            return back();
        }

        $surveysList = LimeSurveys::where('type_id', '=', 0);
        if (isset($surveys) && $type_survey == 0) {
            $surveysList = $surveysList->whereIn('sid', $surveys);
        }
        $surveysList = $surveysList->get();
        $resultSet = [];
        foreach ($surveysList as $item) {
            $items = DB::connection('mysql_lime')->table('tokens_' . $item->sid)->select();
            if ($type_survey != 3 && $type_survey != 0) {
                $items = $items->where('completed', $type_survey == 1 ? '<>' : "=", "N");
            }
            $data = $items->where('participant_id', '=', $user->ls_participant_id)->first();
            if (!isset($data)) {
                continue;
            }
            $oprosName = LimeSurveysLanguageSettings::where(['surveyls_survey_id' => $item->sid])->first()->surveyls_title;

            $data = (array)DB::connection('mysql_lime')->table('survey_' . $item->sid)->where('token', '=', $data->token)->first();
            $resultSet[$oprosName] = [];
            if (!isset($data) || empty($data)) {
                continue;
            }

            $questions = LimeSurveysQuestions::where('sid', '=', $item->sid)->get();
            foreach ($questions as $question) {
                $itemName = $item->sid . 'X' . $question->gid . "X" . $question->qid;
                $answer = $data[$itemName];
                $answerData = LimeSurveysQuestionsAnswers::where(['qid' => $question->qid, 'code' => $answer])->first();
                $resultSet[$oprosName][$question->question] = $answerData->answer;
            }
        }
        $fileName = $user->id . "_" . time() . ".txt";
        $filePath = storage_path('app/download/' . $fileName);
        file_put_contents($filePath, "Пользователь " . $user->name . " " . $user->second_name . " email: " . $user->email . "\nАнкеты:\n\n");

        foreach ($resultSet as $key => $item) {
            $str = $key . "\n";
            $i = 1;
            foreach ($item as $question => $answer) {
                $str .= $i . '. ' . $question . "  " . $answer . PHP_EOL;
                $i++;
            }
            file_put_contents($filePath, $str . PHP_EOL, 8);
        }

        return response()->download($filePath);
    }

    public function notFinishedWorksheets(Request $request)
    {

    }

    public function allWorksheets(Request $request)
    {

    }

    private function icv($str)
    {
        $res = "=\"" . iconv("UTF-8", "Windows-1251//IGNORE", $str) . "\"";
        return $res;
    }

}
