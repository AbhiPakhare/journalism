<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeStaffNotification extends Notification
{
    use Queueable;
    private $staff;
    /**
     * Create a new notification instance.
     *
     * @param $staff
     */
    public function __construct($staff)
    {
        $this->staff = $staff;
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
                    ->subject('Welcome '.$this->staff->role->name)
                    ->greeting('Welcome '.$this->staff->role->name)
                    ->line('Credentials :')
                    ->line('Email: '. $this->staff->email)
                    ->line('Password: test@1234')
                    ->action('Login now', route('login'))
                    ->line('Once Logged in kindly reset your password to do the further task')
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
