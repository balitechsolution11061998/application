<?php

namespace App\Events;

use App\Models\Izin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\Broadcastable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IzinRequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $izin;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Izin $izin)
    {
        $this->izin = $izin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('izin-notifications');
    }

    public function broadcastWith()
    {
        return [
            'izin' => $this->izin
        ];
    }
}
