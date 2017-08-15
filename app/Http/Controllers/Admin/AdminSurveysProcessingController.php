<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Lime\LimeParticipants;
use App\Models\Lime\LimeSurveyLinks;
use App\Models\Lime\LimeSurveysQuestions;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use App\Models\Lime\LimeSurveys;
use App\User;
use Illuminate\Support\Facades\DB;

class AdminSurveysProcessingController extends Controller
{
    public function index()
    {
        $users = LimeParticipants::all();
        $surveys = LimeSurveys::where(['type_id' => 0])->get();
        return view('admin.processing.index', [
            'users' => $users,
            'surveys' => $surveys
        ]);
    }

    public function finishedWorksheets(Request $request)
    {
        $daterange = $request->get('date');
        if (isset($daterange)) {
            $find = stripos($daterange, ' -');
            $date_from = substr($daterange, 0, $find);
            $date_to = substr($daterange, $find + 3);
        }
        $export_type = $request->get('export_type');
        $user = $request->get('user');
        $surveys = $request->get('surveys');
        $type_survey = $request->get('type_survey');

        if (!isset($export_type)) {
            Toastr::error('Не указан обязательный параметр!', 'Ошибка!');
            return back();
        }

        if ($export_type == 1) {
            $surveysList = LimeSurveys::where('type_id', '=', 0)->get();
            foreach ($surveysList as $item) {
                $items = DB::connection('mysql_lime')->table('tokens_' . $item->sid)->select();
                if ($type_survey != 3) {
                    $items->where('completed', $type_survey == 1 ? '<>' : "=", "N");
                }

                if (isset($daterange) && $type_survey == 1) {
                    $items->whereBetween('completed', [$date_from, $date_to]);
                }

                $items->where('participant_id', '=', $user);

                $data = $items->first();

                if (!isset($data)) {
                    continue;
                }
                $data = DB::table('survey_' . $item->sid)->connection('mysql_lime')->where('token', '=', $data->token)->first();
                if (!isset($data)) {
                    continue;
                }

                $questions = LimeSurveysQuestions::where('sid','=',$item->sid)->get();

            }
        }

        $lime_base = DB::connection('mysql_lime');

        $surveys = $lime_base->table('participants')
            ->join('survey_links', 'participants.participant_id', '=', 'survey_links.participant_id')
            ->select('*')
            ->get();

        dd($surveys);

        $dt = microtime();

        if (!file_exists(storage_path('app/csv/'))) {
            mkdir(storage_path('app/csv/'));
        }
        $file = fopen(storage_path('app/csv/') . "export_finished_worksheets" . $dt . ".csv", 'w');
        fputcsv($file, [
            'Имя',
            'Токен',
            'Страна',
            'Регион',
            'Город',
            'Пол',
            'Дата рождения',
            'Название опроса',
            'Вопрос',
            'Ответ',
        ], ";");
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
