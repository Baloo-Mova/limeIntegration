<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendMessage;
use App\Helpers\Macros;
use PHPMailer;
use Brian2694\Toastr\Facades\Toastr;

class AdminMessagesController extends Controller
{

    public function index()
    {
        return view('admin.messages.index');
    }

    public function createMessage()
    {
        $users = User::all();
        return view('admin.messages.create', with([
            'users' => $users
        ]));
    }

    public function sendBaseMessage(Request $request)
    {
        $text = $request->get('text');
        $users = $request->get('user');
        $send_all = $request->get('send_all');

        if(!isset($text)){
            return back();
        }

        if($send_all == "on"){
            $users = User::all();
            if(!isset($users)) {
                Toastr::error('Сообщение не отправлено!', 'Ошибка');
                return back();
            }
            foreach ($users as $user){
                if($user->role_id == 2){
                    continue;
                }
                $user->notify(new SendMessage($text));
            }
        }else{
            foreach ($users as $user){
                $u = User::find($user);
                if(!isset($u)) {
                    Toastr::error('Сообщение не отправлено!', 'Ошибка');
                    return back();
                }
                $u->notify(new SendMessage($text));
            }
        }

        Toastr::success('Сообщение успешно отправлено!', 'Отправлено');
        return back();

    }

    public function sendBaseMessageToList(Request $request)
    {
        $text = $request->get('text');
        $users = $request->get('participant');

        if(!isset($users) || !isset($text)){
            Toastr::error('Сообщение не отправлено!', 'Ошибка');
            return back();
        }
        foreach ($users as $user){
            $u = User::where(['ls_participant_id' => $user])->first();
            if(!isset($u)) {
                Toastr::error('Сообщение не отправлено!', 'Ошибка');
                return back();
            }
            $u->notify(new SendMessage($text));
        }
        Toastr::success('Сообщение успешно отправлено!', 'Отправлено');
        return back();
    }

    public function createEmailMessage()
    {
        $users = User::all();
        return view('admin.messages.email', with([
            'users' => $users
        ]));
    }

    public function sendEmailMessage(Request $request)
    {
        $user_email = $request->get('user');
        $text_tmp = $request->get('text');
        $smtp = $request->get('smtp');
        $port = $request->get('port');
        $login = $request->get('login');
        $pasw = $request->get('pasw');

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
            $mail->setFrom(\Auth::user()->email);
            $mail->addAddress($user_email);     // Add a recipient

            $mail->Subject = "Сообщение от админа";
            $mail->Body = $text;

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
