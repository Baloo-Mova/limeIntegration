<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

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
            'text' => $message["text"],
            'greeting' => $message["greeting"],
            'action_title' => $message["action_title"],
            'button' => $message["button"],
            'subject' => $message["subject"],
            'url' => $message["url"]
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
        return (new MailMessage)
                    ->subject($this->message["subject"])
                    ->greeting($this->message["greeting"])
                    ->line($this->message["text"])
                    ->action($this->message["action_title"], url($this->message["url"]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return new DatabaseMessage([
            'message' => $this->message["greeting"]."<br>".$this->message["text"]."<br>".$this->message["button"]
        ]);
    }
}
