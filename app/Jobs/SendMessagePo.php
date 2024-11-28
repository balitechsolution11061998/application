<?php

namespace App\Jobs;

use App\Mail\SendPoToSupplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Helpers\SystemUsageHelper;
use Spatie\Activitylog\Facades\LogActivity;

class SendMessagePo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data payload for the job.
     */
    protected $payload;

    /**
     * Create a new job instance.
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Record the start time and memory usage
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            // Extract email data from the payload
            $supplierEmail = $this->payload['email'];
            $supplierName = $this->payload['name'];
            $orderNumber = $this->payload['order_no'];
            $totalAmount = $this->payload['total_amount'];
            $downloadLink = $this->payload['download_link'];

            // Send email to the supplier
            Mail::to($supplierEmail)->send(new SendPoToSupplier(
                $supplierName,
                $orderNumber,
                $totalAmount,
                now()->toDateString(),
                $downloadLink
            ));

            // Log success
            activity()
                ->withProperties(['email' => $supplierEmail, 'order_no' => $orderNumber])
                ->log('Purchase Order email sent successfully to ' . $supplierEmail);

        } catch (\Exception $e) {
            // Log failure
            activity()
                ->withProperties(['error' => $e->getMessage(), 'order_no' => $this->payload['order_no']])
                ->log('Failed to send Purchase Order email');
        } finally {
            // Log the system usage regardless of success or failure
            SystemUsageHelper::logUsage($startTime, $startMemory);
        }
    }
}
