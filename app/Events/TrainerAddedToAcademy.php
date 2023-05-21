<?php

namespace App\Events;

use App\Models\Academy;
use App\Models\Trainer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TrainerAddedToAcademy
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $trainer;
    public $academy;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Trainer $trainer, Academy $academy)
    {
        $this->trainer = $trainer;
        $this->academy = $academy;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
