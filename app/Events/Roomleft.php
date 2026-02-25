<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomLeft implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $room_id;

    public function __construct($username, $room_id)
    {
        $this->username = $username;
        $this->room_id = $room_id;
    }

    public function broadcastOn()
    {
        return [new Channel('chatMessage' . $this->room_id)];
    }

    public function broadcastAs(): string
    {
        return 'room.left';
    }
}
