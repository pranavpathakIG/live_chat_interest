<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class preview implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $room_id;

    public function __construct($username, $message, $room_id)
    {
        $this->username = $username;
        $this->message = $message;
        $this->room_id = $room_id;
    }

    public function broadcastOn()
    {
        return [new Channel('chatMessage' . $this->room_id)];
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }
}
