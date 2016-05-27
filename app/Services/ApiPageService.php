<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;

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
     * get all pages
     *
     * @method all
     *
     * @param  bool $includes determins if defaultincludes are included or nor
     *
     * @return array
     */
    public function all($includes = false)
    {

    }
    /**
     * get page(s) by id
     *
     * @method get
     *
     * @param  string|array $ids
     *
     * @return array
     */
    public function get($ids = NULL, $parameters = NULL, $includes = true)
    {
        // no ids provided
        if($ids === NULL){
            return [];
        }
        // turn $ids into array if not
        is_array($ids) ?: $ids = [$ids];
        // build url
        $url = '/pages?filter[id]='.trim(implode(',',$ids),',');
        // add parameters
        $url .= $this->parameters($parameters, $includes);
        // get pages
        $page_data = $this->getAllItems($url);

        foreach($page_data['data'] as $page){
            $pages[] = [
                'id'            => $page['id'],
                'label'         => $page['attributes']['menu_label'],
                'link'          => '/pages/'.$page['attributes']['slug'],
                'title'         => $page['attributes']['title'],
                'description'   => $page['attributes']['description'],
                'published'     => $page['attributes']['published'],
                'language'      => $page['attributes']['language'],
                'is_trashed'    => $page['attributes']['is_trashed'],
                'collections'   => $this->addIncluded('collections', $page, $page_data['included']),
                'pages'         => $this->addIncluded('pages', $page, $page_data['included']),
                'fragments'     => $this->addIncluded('fragments', $page, $page_data['included']),
                'metadetails'   => $this->addIncluded('metadetails', $page, $page_data['included']),
            ];
        }
        // request
        return $pages;
    }
    /**
     * find page by slug
     *
     * @method get
     *
     * @param  [type] $slug [description]
     *
     * @return [type]
     */
    public function find($slug)
    {

    }
}
