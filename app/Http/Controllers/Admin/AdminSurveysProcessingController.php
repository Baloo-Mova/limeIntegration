<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Lime\LimeSurveyLinks;
use Illuminate\Http\Request;
use App\Models\Lime\LimeSurveys;
use App\User;

class AdminSurveysProcessingController extends Controller
{
    public function index()
    {
        return view('admin.processing.index');
    }

    public function finishedWorksheets()
    {
        $surveys = LimeSurveyLinks::all();
        dd($surveys->worksheetsForAllUsers);
    }

    public function notFinishedWorksheets()
    {

    }

    public function allWorksheets()
    {

    }

}
