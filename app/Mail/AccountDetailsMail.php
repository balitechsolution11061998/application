<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $email;
    public $password;

    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.account_details') // Specify the view for the email
                    ->subject('Your Account Details')
                    ->with([
                        'username' => $this->username,
                        'email' => $this->email,
                        'password' => $this->password,
                    ]);
    }
}
