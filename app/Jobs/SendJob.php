<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PHPMailer;
use App\Helpers\Macros;
use App\Models\Settings;

class SendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = [
            'url' => $message["url"],
            'name' => $message["name"],
            'surname' => $message["surname"],
            'email' => $message["email"],
            'type' => $message["type"],
            'button' => $message["button"]
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $settings = Settings::find(1);
        if(!isset($settings)){
            return false;
        }

        if($this->message['type'] == "new_survey"){
            $subject = 'Новый опрос для Вас';
            $text_tmp = Macros::convertMacro($settings->new_message_text);
        }else{
            $subject = 'Напоминание об опросе';
            $text_tmp = Macros::convertMacro($settings->remind_message_text);
        }

        $text = str_replace(["[name]", "[surname]", "[link]"],
            [ $this->message['name'],  $this->message['surname'], $this->message['url']],
            $text_tmp);

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
            $mail->setFrom(\Auth::user()->email);
            $mail->addAddress( $this->message['email']);     // Add a recipient

            $mail->Subject = $subject;
            $mail->Body = $text;

            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }
}
