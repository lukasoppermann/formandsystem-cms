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

    public function show($slug){
        $data['page'] = (new ApiPageService)->find($slug);
        dd($data['page']);

        $data['navigation'] = $this->buildNavigation('/pages/'.$slug);

        return view('pages.page', $data);
    }

}
