<?php

namespace App\Events;

use App\Events\Event;
use App\Paper;
use Faker\Provider\UserAgent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReviewerPaperSet extends Event
{
    use SerializesModels;

    public $paper;
    /*
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Paper $paper)
    {
        $this->paper = $paper;
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
