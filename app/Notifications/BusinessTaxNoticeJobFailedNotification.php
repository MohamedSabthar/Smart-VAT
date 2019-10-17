<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BusinessTaxNoticeJobFailedNotification extends Notification
{
    use Queueable;
    public $vatPayerId;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vatPayerId)
    {
        $this->vatPayerId = $vatPayerId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //
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
            'data' => "Buisness Tax Notification sending failed for Vatpayer id : ".$this->vatPayerId,
        ];
    }
}