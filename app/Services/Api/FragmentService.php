<?php

namespace App\Services\Api;

class FragmentService extends AbstractApiService
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
}
