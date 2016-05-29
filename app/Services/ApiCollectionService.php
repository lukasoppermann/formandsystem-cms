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
    public function get($ids)
    {

    }
    /**
     * find collection by slug
     *
     * @method find
     *
     * @param  string $slug
     *
     * @return App/Entities/Page
     */
    public function find($slug, $param = [])
    {
        $url = '/collections?filter[slug]='.$slug;
        // add parameters
        // TODO: deal with includes & params as one array
        // $url .= $this->parameters($param['parameters'], $param['includes']);
        // TODO: deal with errors, e.g. 404
        $item = $this->api($this->client)->get($url);
        // return
        return new Collection($item['data'][0], $item['included']);
    }
}
