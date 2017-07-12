<?php

namespace App\Http\Controllers\Admin;

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
use App\Http\Controllers\Controller;


class AdminSiteController extends Controller
{
    public $client;
    //
    public function index() {
       // $surveys =  LimeSurveys::get();


     $limeSurveysLinks =  Auth::user()->participant->getGlobalSurveyLinks()->paginate(20);

        return view('frontend.site.index')->with(
            [
                'surveys' =>$limeSurveysLinks,

            ]


        );
    }

    public function indexProfiles(){
        // $surveys =  LimeSurveys::get();
        $limeSurveysLinks =  Auth::user()->participant->getSurveyLinks()->paginate(20);

        return view('frontend.profiles.index')->with(
            [
                'surveys' =>$limeSurveysLinks,

            ]


        );

    }
    public function welcome(){

        return view('welcome');

    }

}
