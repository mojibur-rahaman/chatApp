<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class activeUserStatus implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


   
    /**
     * Create a new event instance.
     */
    public function __construct(public User $user)
    {

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('online-users'),
        ];
    } 

    /**
     * retrun id
     */
    // public function broadcastWith() : array
    // {
    //     return [
    //         'user' => [
    //             'id' => $this->user->id, 
    //             'name' => $this->user->name, 
    //         ]
    //     ];
    // }

    
}
