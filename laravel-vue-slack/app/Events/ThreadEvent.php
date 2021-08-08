<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;

    public $threadMessage;

    public $parentMessageId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $threadMessage, $parentMessageId)
    {
        $this->channel = $channel;
        $this->threadMessage = $threadMessage;
        $this->parentMessageId = $parentMessageId;
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
        return 'ThreadEvent';
    }
}
