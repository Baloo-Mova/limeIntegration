<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\User;
use App\Models\Lime\User as LimeUser;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Lime\LimeSurveys;
use App\Models\Lime\LimeSurveysLanguageSettings;
use Carbon\Carbon;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use org\jsonrpcphp\JsonRPCClient;


class SiteController extends Controller
{
    public $client;

    public function index()
    {
        $user = Auth::user();
        $limeSurveysLinks = $user->participant->getGlobalSurveyLinks()->paginate(20);

            return view('frontend.site.index')->with(
                [
                    'surveys' => $limeSurveysLinks,
                ]
            );

    }

    public function indexProfiles()
    {
        $user = Auth::user();
        $limeSurveysLinks = $user->participant->getSurveyLinks()->paginate(20);

        return view('frontend.profiles.index')->with(
            [
                'surveys' => $limeSurveysLinks,
                'user_info' => $user
            ]
        );

    }

    public function welcome()
    {
        return view('welcome');
    }

    public function gotoSurvey($id_survey, $token)
    {
        $settings = LimeSurveysLanguageSettings::where(['surveyls_survey_id' => $id_survey])->update([
            'surveyls_url' => config('app.url') . 'updatebalance/' . $id_survey,

        ]);
        return redirect(config('lime.ls_baseurl') . $id_survey . '?token=' . $token);

    }
}
