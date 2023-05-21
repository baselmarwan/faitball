<?php

namespace App\Listeners;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\TrainerAddedToAcademy;
use App\Notifications\TrainerAddedNotification;

class NotifyOtherTrainers
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
     * @param  object  $event
     * @return void
     */
    public function handle(TrainerAddedToAcademy $event)
    {
        $newTrainer = $event->trainer;
        $trainers = $newTrainer->academy->trainers
            ->where('id', '!=', $newTrainer->id);
        // Notify other trainers
        foreach ($trainers as $trainer) {
            $trainer->notify(new TrainerAddedNotification($newTrainer));
        }
    }
}
