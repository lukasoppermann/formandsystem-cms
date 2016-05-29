<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Requests;
use Cache;
use App\Http\Controllers\Controller;
use App\Services\ApiCollectionService;
use App\Services\ApiPageService;
use App\Entities\Collection;

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

    public function getMenu()
    {
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
        $collection = (new ApiCollectionService)->find('pages');
        // TODO: use collection above and fix
        $item = $this->api($this->client)->get('/collections?filter[slug]=pages&include=pages&exclude=pages.fragments');

        $collection = new Collection($item['data'][0], $item['included']);

        // get all ids of needed pages
        foreach($collection->pages as $page){
            $page_ids[] = $page->id;
        }
        // $page_ids[] = 'cf6a3a83-4c39-34a1-910c-b43d7121a0fa';
        // // get all pages
        $pages = (new ApiPageService)->get($page_ids,NULL,false);
        // // prepare for navigation
        return [
            [
                'items' => $pages,
                'add' => [
                    'link' => '/pages/create'
                ],
                'deletable' => true,
            ]
        ];
    }

    public function index(){
        $this->getMenu();
        $data['navigation'] = $this->buildNavigation('/pages');
        return view('pages.dashboard', $data);
    }

    public function show($slug){
        $this->getMenu();
        $data['page'] = (new ApiPageService)->find($slug);

        $data['navigation'] = $this->buildNavigation('/pages/'.$slug);

        return view('pages.page', $data);
    }
    /**
     * create new page instance
     *
     * @method store
     */
    public function store()
    {
        $page = (new ApiPageService)->store([
            'menu_label' => 'New Page',
            'slug'       => 'new-page',
            'published'  => false,
            'language'  => 'de',
        ]);

        $collection = (new ApiCollectionService)->find('pages');

        $response = $this->api($this->client)->post('/collections/'.$collection->id.'/relationships/pages', [
            'type' => 'pages',
            'id'   => $page['data']['id'],
        ]);


        return redirect('pages/new-page');
    }

}
