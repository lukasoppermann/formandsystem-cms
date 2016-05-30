<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;
use App\Entities\Page;

class ApiPageService extends AbstractApiService
{
    /**
     * all available includes
     *
     * @var array
     */
    protected $includes = [
        'fragments',
        'pages',
        'collections',
        'metadetails',
        'ownedByPages',
        'ownedByCollections',
    ];
    /**
     * the name of the entity
     *
     * @var string
     */
    protected $entity = '\App\Entities\Page';
    /**
     * the api endpoint to connect to
     *
     * @var string
     */
    protected $endpoint = 'pages';
    /**
     * store
     *
     * @method store
     *
     * @return EXCEPTION|array
     */
    public function store(Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->post('/pages', [
            'type' => 'pages',
            'attributes' => $data,
        ]);

        return $response;
    }
}
