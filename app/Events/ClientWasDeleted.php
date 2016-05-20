<?php

namespace App\Events;

use App\Events\Event;

class ClientWasDeleted extends Event
{

    public $client_id;

    /**
     * Create a new event instance.
     *
     * @param  string $client_id
     * @return void
     */
    public function __construct($client_id)
    {
        $this->client_id = $client_id;
    }
}
