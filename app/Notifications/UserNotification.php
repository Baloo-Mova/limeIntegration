<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use PHPMailer;
use App\Helpers\Macros;
use App\Models\Settings;

class UserNotification extends Notification
{
    use Queueable;
    private $message;
    private $via;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $via)
    {
        $this->message = [
            'url' => $message["url"],
            'type' => $message["type"],
            'button' => $message["button"]
        ];
        $this->via = $via;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        switch ($this->via){
            case "all":
                return ['mail', 'database'];
                break;
            case "mail":
                return ['mail'];
                break;
            case "database":
                return ['database'];
                break;
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
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
                            [$notifiable->name, $notifiable->second_name, $this->message['url']],
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
            $mail->addAddress($notifiable->email);     // Add a recipient

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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $text_tmp = Macros::convertMacro($this->message['text']);

        $text = str_replace(["[name]", "[surname]", "[link]"],
            [$this->user->name, $this->user->second_name, $this->message['url']],
            $text_tmp);

        return new DatabaseMessage([
            'message' => $text."<br>".$this->message["button"]
        ]);
    }
}
