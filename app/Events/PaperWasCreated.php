<?php

namespace App\Events;

use App\Paper;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaperWasCreated extends Event
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
        $this->operation = 'uploaded';
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
