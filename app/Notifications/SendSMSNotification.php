<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class SendSMSNotification extends Notification
{
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ["vonage"];

    }

    public function toVonage($notifiable)
    {
        return (new VonageMessage)
            ->from('darcom')
            ->content('the verification code is ' . $this->user->verification_code);
    }
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
