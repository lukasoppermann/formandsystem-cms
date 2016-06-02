<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;
use App\Entities\Collection;

class ApiCollectionService extends AbstractApiService
{
    /**
     * all available includes
     *
     * @var array
     */
    protected $includes = [
        'pages',
        'ownedByPages',
        'collections',
        'ownedByCollections',
        'fragments',
        'ownedByFragments',
    ];
    /**
     * the name of the entity
     *
     * @var string
     */
    protected $entity = '\App\Entities\Collection';
    /**
     * the api endpoint to connect to
     *
     * @var string
     */
    protected $endpoint = 'collections';
    /**
     * create item
     *
     * @method create
     *
     * @param  string $name
     * @param  string $slug
     *
     * @return App\Entities\Collection
     */
    public function create($name, $slug = NULL)
    {
        // get slug
        $slug = $slug !== NULL ? $slug : urlencode($name);
        // create collection
        $item = $this->api($this->client)->post('/collections',[
            'type' => 'collections',
            'attributes' => [
                'name' => $name,
                'slug' => $slug,
            ]
        ]);
        //TODO: deal with errors
        // return entity
        return new Collection($item['data']);
    }
}
