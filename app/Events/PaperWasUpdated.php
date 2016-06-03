<?php

namespace App\Events;

use App\Events\Event;
use App\Paper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaperWasUpdated extends Event
{
    use SerializesModels;

    public $paper;
    public $operation;

    /*
     * Create a new event instance.
     *
     * @param  Paper $paper
     * @return void
     */
    public function __construct(Paper $paper)
    {
        $this->paper = $paper;
        $this->operation = 'changed';
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
