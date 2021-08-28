<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;

    public $channelId;

    public $message;

    public $messageId;

    public $isThreadMessage;

    public $threadMessageCount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $channelId, $message, $messageId, $isThreadMessage, $threadMessageCount = 0)
    {
        $this->channel = $channel;
        $this->channelId = $channelId;
        $this->message = $message;
        $this->messageId = $messageId;
        $this->isThreadMessage = $isThreadMessage;
        $this->threadMessageCount = $threadMessageCount;
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
        return 'MessageEvent';
    }
}
