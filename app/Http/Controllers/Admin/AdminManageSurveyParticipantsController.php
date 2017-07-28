<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lime\LimeSurveys;
use App\Models\Surveys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminManageSurveyParticipantsController extends Controller
{
    public function index()
    {
        $surveys = LimeSurveys::where(['type_id' => 1])->get();
        return view('admin.manage.index', with([
            'surveys' => $surveys
        ]));
    }
}
