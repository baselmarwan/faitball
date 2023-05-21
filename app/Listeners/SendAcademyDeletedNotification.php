<?php

namespace App\Listeners;

use App\Events\AcademyDeleted;
use App\Notifications\AcademyDeletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendAcademyDeletedNotification
{
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
     * @param  \App\Events\AcademyDeleted  $event
     * @return void
     */
    public function handle(AcademyDeleted $event)
    {
        $academy = $event->academy;
        $user = $event->user;

        $notification = new AcademyDeletedNotification($academy);

        $user->notify(new AcademyDeletedNotification($academy));
    }
}
