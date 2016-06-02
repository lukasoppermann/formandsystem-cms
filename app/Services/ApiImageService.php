<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;
use App\Entities\Collection;

class ApiImageService extends AbstractApiService
{
    /**
     * all available includes
     *
     * @var array
     */
    protected $includes = [

    ];
    /**
     * the name of the entity
     *
     * @var string
     */
    protected $entity = '\App\Entities\Image';
    /**
     * the api endpoint to connect to
     *
     * @var string
     */
    protected $endpoint = 'images';
    /**
     * create
     *
     * @method create
     *
     * @return EXCEPTION|array
     */
    public function create(Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->post('/'.$this->endpoint, [
            'type' => $this->endpoint,
            'attributes' => $data,
        ]);
        return $response;
    }

    public function upload()
    {
        
    }
}
