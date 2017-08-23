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
use PHPMailer;
use App\Models\Settings;


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

        return redirect(route('verify.email.success'));
    }

    public function verifyEmailSuccess()
    {
        return view('verified');
    }

    public function verifyEmailRepeat($user_id)
    {
        $user = User::find($user_id);
        if(!isset($user)){
            Toastr::error("Нет такого пользователя", "Ошибка");
            return back();
        }

        $token = $this->gen_uuid();
        $user->token = $token;
        $user->save();

        $settings = Settings::find(1);
        if(!isset($settings)){
            Toastr::error("Ошибка", "Ошибка");
            return back();
        }

        try {
            $mail = new PHPMailer;
            // $mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $settings->smtp;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $settings->smtp_login;                 // SMTP username
            $mail->Password = $settings->smtp_pasw;                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $settings->smtp_port;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($settings->smtp_login);
            $mail->addAddress( $user->email);     // Add a recipient

            $mail->Subject = "Подтверждение регистрации";
            $url = "<a href='".route('verify.email', ['user_id' => $user->id, 'token' => $token])."'>ссылке</a>";
            $mail->Body = "Здравствуйте, ".$user->name." ".$user->second_name."! Спасибо за регистрацию на нашем сайте. Для потверждения регистрации, пройдите по ".$url;
            $mail->isHTML(true);

            if (!$mail->send()) {
                Toastr::error("Не удалось отправить письмо!", "Ошибка");
                return back();
            } else {
                Toastr::success("Письмо успешно отправлено!", "Отправлено");
                return back();
            }
        } catch (\Exception $ex) {
            Toastr::error("Не удалось отправить письмо!", "Ошибка");
            return back();
        }

        return back();
    }

    protected function gen_uuid()
    {
        return sprintf(
            '%04x%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000
        );
    }
}
