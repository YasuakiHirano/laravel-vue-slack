<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MentionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;

    public $message;

    public $speakerImagePath;

    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $message, $userId, $speakerImagePath)
    {
        $this->channel = $channel;
        $this->message = $message;
        $this->userId = $userId;
        $this->speakerImagePath = $speakerImagePath;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [$this->channel];
    }

    public function broadcastAs()
    {
        return 'MentionEvent';
    }
}
