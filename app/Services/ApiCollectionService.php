<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;

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
     * get all pages
     *
     * @method all
     *
     * @param  string $parameters additional url parameters
     * @param  bool $includes determins if defaultincludes are included or not
     *
     * @return array
     */
    public function all($parameters = NULL, $includes = false)
    {
        // get excludes
        $parameters .= $this->excludes($includes);
        // prepare request url
        $url = trim('/collections?'.trim($parameters,'&'),'?');
        // get collection
        return $this->api($this->client)->get($url);
    }
    /**
     * get page by slug
     *
     * @method get
     *
     * @param  [type] $slug [description]
     *
     * @return [type]
     */
    public function get($slug)
    {

    }
}
