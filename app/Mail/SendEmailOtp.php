<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // This will hold the data passed to the email

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data; // Assign the data to the public property
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.otp') // Specify the view for the email
                    ->subject('Your OTP Code') // Set the email subject
                    ->with(['otp' => $this->data]); // Pass the OTP to the view
    }
}
