<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Requests;
use Cache;
use App\Http\Controllers\Controller;

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
        $pages = [];
        $collection = $this->api($this->client)->get('/collections?filter[slug]=pages');
        dd($collection['data'][0]['id']);
        // $this->getWhileNext($pages, '/collections/'.$collection['data'][0]['id'].'/pages');
        dd($this->api($this->client)->get('/collections/'.$collection['data'][0]['id'].'/pages'));
        // prepare for navigation
        foreach($pages as $page){
            $items[] = [
                'id'        => $page['id'],
                'label'     => $page['attributes']['menu_label'],
                'link'      => '/pages/'.$page['attributes']['slug'],
                'published' => $page['attributes']['published'],
                'language'  => $page['attributes']['language'],
            ];
        }

        return [
            [
                'items' => $items
            ]
        ];
    }

    public function index(){
        $data['navigation'] = $this->buildNavigation('/pages');
        return view('pages.dashboard', $data);
    }

    protected function getWhileNext(&$items, $url)
    {
        $response = $this->api($this->client)->get($url);

        $items = array_merge(array_values($items), array_values($response['data']));

        if( isset($response['meta']['pagination']['links']['next']) ){
            $this->getWhileNext($items, $response['meta']['pagination']['links']['next']);
        }
    }

    public function show($page){
        $page_content = $this->api($this->client)->get('/pages/?filter[slug]='.$page);
        $data = $page_content['data'][0]['attributes'];

        $data['navigation'] = $this->buildNavigation('/pages/'.$page);

        return view('pages.page', $data);
    }

}
