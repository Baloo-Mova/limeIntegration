<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use PHPMailer;
use App\Models\Settings;
use App\Helpers\Macros;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $settings = Settings::find(1);
        if(!isset($settings)){
            Toastr::error("Ошибка настроек системы! Обратитесь к администратору.");
            return back();
        }

        $email = $request->get('email');
        if(!isset($email)){
            Toastr::error("Укажите E-mail");
            return back();
        }
        $user = User::where('email', '=', $email)->first();
        if(!isset($user)){
            Toastr::error("Пользователь с таким E-mail не существует!");
            return back();
        }

        $token = uniqid();

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => bcrypt($token),
            'created_at' => Carbon::now()
        ]);

        $text_tmp = Macros::convertMacro($settings->reset_password_message_text);

        $url = url("/password/reset/" . $token);

        $text = str_replace(["[name]", "[surname]", "[resetlink]"],
            [ $user->name,  $user->second_name, $url],
            $text_tmp);

        try {
            $mail = new PHPMailer;
            // $mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $settings->smtp;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $settings->smtp_login;                 // SMTP username
            $mail->Password = $settings->smtp_pasw;                           // SMTP password
            $mail->SMTPSecure = $settings->secure;                           // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $settings->smtp_port;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($settings->smtp_login);
            $mail->addAddress($email);     // Add a recipient

            $mail->Subject = "Восстановление пароля";
            $mail->Body = $text;
            if(preg_match("/<[^<]+>/", $text, $m) != 0){
                $mail->IsHTML(true);
            }

            $mail->send();
        } catch (\Exception $ex) {
            Toastr::error("Ошибка!");
            return back();
        }

        return back()->with('status', 'Ссылка на сброс пароля была отправлена! ');

    }
}
