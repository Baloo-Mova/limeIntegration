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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;


class SiteController extends Controller
{
    public $client;

    public function index()
    {
        $user = Auth::user();
        $participant = $user->participant;
        if(!isset($participant)){
            $limeSurveysLinks = [];
        }else{
            $limeSurveysLinks = $participant->getGlobalSurveyLinks()->paginate(20);
        }

        return view('frontend.site.index')->with(
            [
                'surveys' => $limeSurveysLinks,
            ]
        );

    }

    public function error($error)
    {
        return view('error', ['error' => $error]);
    }

    public function indexProfiles()
    {
        $user = Auth::user();
        $participant = $user->participant;
        if(!isset($participant)){
            $limeSurveysLinks = [];
        }else{
            $limeSurveysLinks = $user->participant->getSurveyLinks()->paginate(20);
        }

        $regions = DB::table('regions')->select('region_id','title')->where([
            'region_id' => $user->region_id,
            'country_id' => $user->country_id,
        ])->first();
        $cities = DB::table('cities')->select('city_id','title','area')->where([
            'city_id'  => $user->city_id,
            'region_id' => $user->region_id,
            'country_id' => $user->country_id
        ])->first();
        return view('frontend.profiles.index')->with(
            [
                'surveys' => $limeSurveysLinks,
                'user_info' => $user,
                'region' => $regions,
                'city' => $cities
            ]
        );

    }

    public function welcome()
    {
        if(Auth::check()){
            return redirect(route('site.index'));
        }

        return view('welcome');
    }

    public function gotoSurvey($id_survey, $token)
    {
        $settings = LimeSurveysLanguageSettings::where(['surveyls_survey_id' => $id_survey])->update([
            'surveyls_url' => config('app.url') . 'updatebalance/' . $id_survey,

        ]);
        return redirect(config('lime.ls_baseurl') . $id_survey . '?token=' . $token);

    }

    public function changeLocale($locale)
    {
        if (array_key_exists($locale, Config::get('languages'))) {
            Session::put('applocale', $locale);
        }
        return back();
    }

    public function needVerifyEmail()
    {
        return view('needVerify');
    }

    public function verifyEmail($user_id, $token)
    {
        $user = User::find($user_id);
        if(!isset($user)){
            Toastr::error("Данный пользователь не существует.", "Ошибка!");
            return redirect(route('site.index'));
        }

        if($token != $user->token){
            Toastr::error("Ключи регистрации не совпадают", "Ошибка!");
            return redirect(route('site.index'));
        }

        $user->verified = 1;
        $user->token = null;
        $user->save();

        Toastr::success("Вы успешно зарегистрировались в системе.", "Ошибка!");
        return redirect(url('/surveys'));
    }
}
