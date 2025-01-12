<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedOut
{
    use Dispatchable, SerializesModels;

    public $user;
    public $ipAddress;

    public function __construct(User $user, $ipAddress)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
    }
}
