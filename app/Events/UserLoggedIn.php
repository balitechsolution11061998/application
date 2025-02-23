<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedIn
{
    use Dispatchable, SerializesModels;

    public $user;
    public $address;
    public $ipAddress;

    public function __construct(User $user, $address, $ipAddress)
    {
        $this->user = $user;
        $this->address = $address;
        $this->ipAddress = $ipAddress;
    }
}
