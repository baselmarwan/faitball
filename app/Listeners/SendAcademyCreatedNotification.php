<?php

namespace App\Listeners;

use App\Events\AcademyCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\AcademyCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendAcademyCreatedNotification
{  
  use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AcademyCreated  $event
     * @return void
     */
    public function handle($event)
    {
        $academy = $event->academy;
        $user = $event->user;

        $notification = new AcademyCreatedNotification($academy);
        
        $user->notify(new AcademyCreatedNotification($academy));
    }
}
  