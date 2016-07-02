<?php

namespace App\Services\Api;

class MetadetailService extends AbstractApiService
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
    protected $entity = '\App\Entities\Metadetail';
    /**
     * the api endpoint to connect to
     *
     * @var string
     */
    protected $endpoint = 'metadetails';
}
