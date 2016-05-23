<?php

namespace App\Events;

use App\Events\Event;

class ClientWasDeleted extends Event
{

    protected $account;

    /**
     * Create a new event instance.
     *
     * @param  string $client_id
     * @return void
     */
    public function __construct($account)
    {
        $this->account = $account;
    }
    /**
     * return account
     *
     * @method account
     *
     * @return string
     */
    public function account()
    {
        return $this->account;
    }
}
