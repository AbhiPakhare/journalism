<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferencesIdCreated extends Notification
{
    use Queueable;
    private $user;
    private $reference_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $reference_id)
    {
        $this->user = $user;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Journal reference Id :". $this->reference_id. " for " .$this->user->name)
                    ->line($this->user->name.' your journal submitted successfully')
                    ->line("Your reference number is ". $this->reference_id)
                    ->line('Thank you for using our application!');
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
