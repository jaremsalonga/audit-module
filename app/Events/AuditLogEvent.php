<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class AuditLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $response;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $response)
    {
        $this->user = $user;
        $this->response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}