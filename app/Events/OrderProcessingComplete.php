<?php

// app/Events/OrderProcessingComplete.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderProcessingComplete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $successCount;
    public $failCount;
    public $totalPo;
    public $errors;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($successCount, $failCount, $totalPo, $errors)
    {
        $this->successCount = $successCount;
        $this->failCount = $failCount;
        $this->totalPo = $totalPo;
        $this->errors = $errors;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('order-processing');
    }
}
