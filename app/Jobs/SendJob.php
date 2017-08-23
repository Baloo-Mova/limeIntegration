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
use Illuminate\Support\Facades\DB;

class SendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $message;
    private $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $users)
    {
        $this->message = [
            'type' => $message["type"],
            'survey_id' => $message["survey_id"]
        ];
        $this->users = $users;
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
        foreach ($this->users as $user){
            $participant = DB::connection('mysql_lime')->table('tokens_' . $this->message['survey_id'])->where(['participant_id' => $user])->first();

            $url = url("/gotosurvey/" . $this->message['survey_id'] . "/" . $participant->token);
            $button = "Вы можете пройти его по <a href='" . $url . "'>этой ссылке</a>";

            $text = str_replace(["[name]", "[surname]", "[surveylink]"],
                [ $participant->firstname,  $participant->lastname, $url],
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
                $mail->setFrom($settings->smtp_login);
                $mail->addAddress( $participant->email);     // Add a recipient

                $mail->Subject = $subject;
                $mail->Body = $text;
                if(preg_match("/<[^<]+>/", $text, $m) != 0){
                    $mail->IsHTML(true);
                }


                if (!$mail->send()) {
                    continue;
                } else {
                    continue;
                }
            } catch (\Exception $ex) {
                continue;
            }
        }
        return true;

    }
}
