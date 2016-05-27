<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Requests;
use Cache;
use App\Http\Controllers\Controller;
use App\Services\ApiCollectionService;
use App\Services\ApiPageService;

class Pages extends Controller
{
    /**
     * main navigation array
     *
     * @var array
     */
    protected $navigation = [
        'header' => [
            'title' => 'Pages',
            'link' => '/',
        ],
    ];

    public function __construct(Request $request){
        parent::__construct($request);

        if(!Cache::has('pages.navigation')){
            Cache::forever('pages.navigation', $this->getMenuLists());
        }

        $this->navigation['lists'] = Cache::get('pages.navigation');
        Cache::forget('pages.navigation');
    }

    public function getMenuLists()
    {
        // TODO: deal with errors
        // get pages
        $collection = (new ApiCollectionService)->all('filter[slug]=pages&include=pages&exclude=pages.fragments,pages.metadetails,pages.collections', true);
        // get all ids of needed pages
        $page_ids = array_column($collection['data'][0]['relationships']['pages']['data'],'id');
        // get all pages
        $pages = (new ApiPageService)->get($page_ids,NULL,false);
        // prepare for navigation
        return [
            [
                'items' => $pages
            ]
        ];
    }

    public function index(){
        $data['navigation'] = $this->buildNavigation('/pages');
        return view('pages.dashboard', $data);
    }

    public function show($page){
        $page_content = $this->api($this->client)->get('/pages/?filter[slug]='.$page);
        $data = $page_content['data'][0]['attributes'];

        $inclFragments = array_filter($page_content['included'], function($element) {
            return $element['type'] === 'fragments';
        });

        $fragments = $this->getRelationship($page_content['data'][0], 'fragments', $inclFragments);

        // dd($fragments);

        $data['navigation'] = $this->buildNavigation('/pages/'.$page);

        return view('pages.page', $data);
    }

    public function getRelationship($array, $type, $includes)
    {
        $fragments = [];
        foreach($array['relationships'][$type]['data'] as $rel){
            $fragments[] = $includes[array_search($rel['id'], array_column($includes, 'id'))];
            if(isset($fragments[0])){
                $fragments[$type] = $this->getRelationship($fragments[0], $type, $includes);
            }
        }
        return $fragments;
    }

}
