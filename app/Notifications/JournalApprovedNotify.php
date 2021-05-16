<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalApprovedNotify extends Notification
{
    use Queueable;

    private $journal;
    private $status;
    private $user;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $status
     * @param $journal
     * @param $url
     */
    public function __construct($user, $status, $journal, $url)
    {
        $this->url = $url;
        $this->user = $user;
        $this->status = $status;
        $this->journal = $journal;
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
                    ->subject('Journal Reference ID '.$this->journal->reference_id." ".$this->status)
                    ->line('The journal with reference ID:'.$this->journal->reference_id.' has been '.strtolower($this->status))
                    ->line('Please pay the ₹600 through link given below.')
                    ->action('Make Payment', url('user/razorpay/'.$this->url));
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
