<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPoToSupplier extends Mailable
{
    use Dispatchable, Queueable, SerializesModels;

    public $supplierName;
    public $orderNo;
    public $totalAmount;
    public $orderDate;
    public $downloadLink;

    /**
     * Create a new message instance.
     */
    public function __construct($supplierName, $orderNo, $totalAmount, $orderDate, $downloadLink)
    {
        $this->supplierName = $supplierName;
        $this->orderNo = $orderNo;
        $this->totalAmount = $totalAmount;
        $this->orderDate = $orderDate;
        $this->downloadLink = $downloadLink;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Purchase Order ' . $this->orderNo)
                    ->view('emails.send_po_to_supplier')
                    ->with([
                        'supplierName' => $this->supplierName,
                        'orderNo' => $this->orderNo,
                        'totalAmount' => $this->totalAmount,
                        'orderDate' => $this->orderDate,
                        'downloadLink' => $this->downloadLink,
                    ]);
    }
}
