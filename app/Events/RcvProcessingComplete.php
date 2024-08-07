<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RcvProcessingComplete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $successCount;
    public $failCount;
    public $totalCount;
    public $errors;

    /**
     * Create a new event instance.
     *
     * @param int $successCount
     * @param int $failCount
     * @param int $totalCount
     * @param array $errors
     * @return void
     */
    public function __construct($successCount, $failCount, $totalCount, $errors)
    {
        $this->successCount = $successCount;
        $this->failCount = $failCount;
        $this->totalCount = $totalCount;
        $this->errors = $errors;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('rcv-processing');
    }
}
