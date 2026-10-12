<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class Registered
{
    use SerializesModels;

    public $user;
    public $referrer;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function __construct($user, $referrer)
    {
        $this->user = $user;
        $this->referrer = $referrer;
    }
}
