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
     * upload
     *
     * @method upload
     *
     * @return EXCEPTION|array
     */
    public function upload()
    {

    }
}
