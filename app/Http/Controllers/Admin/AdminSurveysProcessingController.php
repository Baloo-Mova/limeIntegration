<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Lime\LimeSurveyLinks;
use Illuminate\Http\Request;
use App\Models\Lime\LimeSurveys;
use App\User;
use Illuminate\Support\Facades\DB;

class AdminSurveysProcessingController extends Controller
{
    public function index()
    {
        return view('admin.processing.index');
    }

    public function finishedWorksheets()
    {
        $lime_base = DB::connection('mysql_lime');

        $surveys = $lime_base->table('participants')
            ->join('survey_links', 'participants.participant_id', '=', 'survey_links.participant_id')
            ->join('survey_links', 'participants.participant_id', '=', 'survey_links.participant_id')
            ->select('*')
            ->get();

        dd($surveys);
    }

    public function notFinishedWorksheets()
    {

    }

    public function allWorksheets()
    {

    }

}
