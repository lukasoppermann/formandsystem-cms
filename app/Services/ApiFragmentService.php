<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Fragment;

class ApiFragmentService extends AbstractApiService
{
    /**
     * all available includes
     *
     * @var array
     */
    protected $includes = [
        'fragments',
        'ownedByFragments',
        'collections',
        'ownedByCollections',
        'ownedByPages',
        'images',
        'metadetails',
    ];
    /**
     * the name of the entity
     *
     * @var string
     */
    protected $entity = '\App\Entities\Fragment';
    /**
     * the api endpoint to connect to
     *
     * @var string
     */
    protected $endpoint = 'fragments';

    /**
     * store
     *
     * @method store
     *
     * @return EXCEPTION|array
     */
    public function create(Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->post('/fragments', [
            'type' => 'fragments',
            'attributes' => $data,
        ]);
        return $response;
    }

    public function update($id, Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->patch('/'.$this->endpoint.'/'.$id, [
            'type' => $this->endpoint,
            'id'   => $id,
            'attributes' => $data,
        ]);

        return $response;
    }
}
