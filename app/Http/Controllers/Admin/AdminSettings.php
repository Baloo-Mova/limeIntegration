<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\Macros;
use PHPMailer;

class AdminSettings extends Controller
{
    public function index(){
        $settings = Settings::find(1);
        return view('admin.settings.index', [
            'settings' => isset($settings) ? $settings : null
        ]);
    }

    public function store(Request $request)
    {

        $sum = $request->get('min_sum');
        $new_message_text = $request->get('new_message_text');
        $remind_message_text = $request->get('remind_message_text');

        if(!isset($sum) && !isset($new_message_text) && !isset($remind_message_text)){
            Toastr::error("Не указан обязательный параметр", "Ошибка");
            return back();
        }

       $settings = Settings::find(1);
       if(!isset($settings)){
           $settings = new Settings();
       }

       $settings->min_sum = $sum;
       $settings->new_message_text = $new_message_text;
       $settings->remind_message_text = $remind_message_text;
       $settings->save();

       Toastr::success("Настройки сохранены!", "Сохранено");
       return back();
    }

    public function saveSmtp(Request $request)
    {
        $settings = Settings::find(1);
        if(!isset($settings)){
            $settings = new Settings();
        }

        $smtp = $request->get('smtp');
        $smtp_port = $request->get('smtp_port');
        $smtp_login = $request->get('smtp_login');
        $smtp_pasw = $request->get('smtp_pasw');

        if(!isset($smtp) || !isset($smtp_port) || !isset($smtp_login) || !isset($smtp_pasw)){
            Toastr::error("Пропущен обязательный параметр!", "Ошибка!");
            return back();
        }

        $settings->smtp = $smtp;
        $settings->smtp_port = $smtp_port;
        $settings->smtp_login = $smtp_login;
        $settings->smtp_pasw = $smtp_pasw;
        $settings->save();

        Toastr::success("Настройки SMTP сохранены!", "Сохранено");
        return back();
    }

    public function checkSmtp(Request $request)
    {
        $user_email = $request->get('email');
        $text_tmp = $request->get('text');
        $smtp = $request->get('smtp');
        $port = $request->get('port');
        $login = $request->get('login');
        $pasw = $request->get('smtp_pasw');

        if(!isset($user_email)){
            return back();
        }
        if(!isset($text_tmp)){
            return back();
        }else{
            $text = Macros::convertMacro($text_tmp);
        }
        if(!isset($smtp)){
            return back();
        }
        if(!isset($port)){
            return back();
        }
        if(!isset($login)){
            return back();
        }
        if(!isset($pasw)){
            return back();
        }

        try {
            $mail = new PHPMailer;
            // $mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $smtp;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $login;                 // SMTP username
            $mail->Password = $pasw;                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $port;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($login);
            $mail->addAddress($user_email);     // Add a recipient

            $mail->Subject = "Проверка SMTP";
            $mail->Body = $text;
            if(preg_match("/<[^<]+>/", $text, $m) != 0){
                $mail->IsHTML(true);
            }

            if (!$mail->send()) {
                Toastr::error('Сообщение не отправлено!', 'Ошибка');
            } else {
                Toastr::success('Сообщение успешно отправлено!', 'Отправлено');
            }
        } catch (\Exception $ex) {
            Toastr::error('Сообщение не отправлено!', 'Ошибка');
            return back();
        }

        return back();
    }
}
