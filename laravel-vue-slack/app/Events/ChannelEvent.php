<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;

    public $channelObject;

    public $makeUserId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $channelObject, $makeUserId)
    {
        $this->channel = $channel;
        $this->channelObject = $channelObject;
        $this->makeUserId = $makeUserId;
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
        return 'ChannelEvent';
    }
}
