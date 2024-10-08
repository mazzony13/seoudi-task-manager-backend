<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   public $status;
   public $user;
   public $task;
    public function __construct($task,$status,$user)
    {
        $this->task = $task;
        $this->status = $status;
        $this->user = $user;
    }

    public function broadcastWith()
    {
        return [
            'msg'=>'Task '.$this->task .' Status changed to '.$this->status.' By '.$this->user
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
            new Channel('user-notification'),
        ];
    }
}
