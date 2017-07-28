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
                'surveys' => $limeSurveysLinks,

            ]


        );

    }
    public function welcome(){

        return view('welcome');

    }

    public function gotoSurvey($id_survey,$token){
   $settings =  LimeSurveysLanguageSettings::where(['surveyls_survey_id'=>$id_survey])->update([
       'surveyls_url' => config('app.url').'updatebalance/'.$id_survey,

   ]);
    return redirect(config('lime.ls_baseurl').$id_survey.'?token='.$token);

    }

    protected function limeRemoteControl(){

        $LS_USER = 'admin' ;
        $LS_PASSWORD = 'admin';

// the survey to process
        $survey_id=457978;


// instanciate a new client
//        $myJSONRPCClient = new JsonRPCClient( config('lime.ls_baceurl').'/admin/remotecontrol');
//
//// receive session key
//        $sessionKey= $myJSONRPCClient->get_session_key( $LS_USER, $LS_PASSWORD );
//dd ($sessionKey);
//// receive all ids and info of groups belonging to a given survey
//        $groups = $myJSONRPCClient->list_groups( $sessionKey, $survey_id );
//        print_r($groups, null );
//
//// release the session key
//        $myJSONRPCClient->release_session_key( $sessionKey );
    }
}
