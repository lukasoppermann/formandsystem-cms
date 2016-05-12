<?php

namespace App\Services;
use Ramsey\Uuid\Uuid;

class AccountService extends AbstractService
{

    public function create($account_name){
        $client = $this->createApiAccountClient($account_name);

        'id'                => (string)Uuid::uuid4(),
        'name'              => $account_name,
        'client_id'         => $client['id'],
        'client_secret'     => $client['secret'],

    }

    protected function createApiAccountClient($account_name){
        $this->api->client()->create($account_name);
    }

}
