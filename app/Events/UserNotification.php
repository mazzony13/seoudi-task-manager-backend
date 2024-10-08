<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $uuid;
    public $user;
    public $task_name;
    /**
     * Create a new event instance.
     */
    public function __construct($uuid,$user,$task_name)
    {
        $this->uuid = $uuid;
        $this->task_name = $task_name;
        $this->user = $user;
    }

    public function broadcastWith()
    {
        return [
            'msg'=>'Task ('.$this->task_name .') Assigned to you By '.$this->user
        ];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel($this->uuid),
        ];
    }
}
