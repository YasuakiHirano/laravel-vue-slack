<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelUserEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;

    public $channelId;

    public $channelUsers;

    public $channelObject;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $channelId, $channelUsers, $channelObject)
    {
        $this->channel = $channel;
        $this->channelId = $channelId;
        $this->channelUsers = $channelUsers;
        $this->channelObject = $channelObject;
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
        return 'ChannelUserEvent';
    }
}
