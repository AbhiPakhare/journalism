<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalStatusNotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $status, $reference_id, $reason)
    {
        $this->user = $user;
        $this->status = $status;
        $this->reason = $reason;
        $this->reference_id = $reference_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable){
        if($this->status == 'Waiting'){
            return (new MailMessage)
                    ->subject('Reference ID :'.$this->reference_id.' Status : '. $this->status)
                    ->line("Reasons:")
                    ->line($this->reason ? $this->reason : "")
                    ->line('Please make the changes and re-submit.');
                    
        }else if($this->status == 'Rejected'){
            return (new MailMessage)
            ->subject('Reference ID :'.$this->reference_id.' Status : '. $this->status)
            ->line("Reasons:")
            ->line($this->reason ? $this->reason : "");
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
        return [
            //
        ];
    }
}
