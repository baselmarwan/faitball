<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Academy;

class AcademyCreatedNotification extends Notification
{
    use Queueable;
    protected $academy;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Academy $academy)
    {
        $this->academy = $academy;
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

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Academy "' . $this->academy->name . '" has been created.',
        ];
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
            //i wrote this part before having access to academy details code, and before the merge of its branch
            //need to be modified
            'type' => 'AcademyCreated',
            'academy_id' => $this->academy->id,
            'academy_name' => $this->academy->name,
            'academy_location' => $this->academy->location,
        ];
    }
}
