<?php

namespace App\Http\Controllers\Collections;

use Illuminate\Http\Request;
use Cache;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ApiCollectionService;

class Collections extends Controller
{

    /**
     * main navigation array
     *
     * @var array
     */
    protected $navigation = [
        'header' => [
            'title' => 'Collections',
            'link' => '/',
        ]
    ];
    /**
     * construct
     *
     * @method __construct
     *
     * @param  Request     $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // get the main navigation items
        $this->getMenu();
    }

    public function getMenu()
    {
        Cache::forget('collections.navigation');
        if(!Cache::has('collections.navigation')){
            Cache::forever('collections.navigation', $this->getMenuLists());
        }
        $this->navigation['lists'] = Cache::get('collections.navigation');

    }

    public function getMenuLists()
    {
        // TODO: deal with errors
        // get all items
        $items = (new ApiCollectionService)->all([
            'includes' => false
        ]);
        // remove pages
        $items = $items->filter(function($item){
            return $item->slug !== 'pages';
        });
        // turn pages into array
        $items = $items->map(function($item){
            $item = $item->toArray();
            $item['link'] = '/collections/'.$item['slug'];
            $item['label'] = $item['name'];
            return $item;
        })->toArray();
        // prepare for navigation
        return [
            [
                'items' => isset($items) ? $items : [],
                'add' => [
                    'link' => '/collections/create'
                ],
            ]
        ];
    }

    public function index(){
        $data['navigation'] = $this->buildNavigation('/collections');

        return view('dashboard.welcome', $data);
    }

    public function store()
    {
        $item = (new ApiCollectionService)->create('New Collection','new-collection');

        return redirect('collections/new-collection');
    }

    public function show($slug)
    {
        $data['navigation'] = $this->buildNavigation('/collections/'.$slug);

        $data['collection'] = (new ApiCollectionService)->first('slug',$slug);

        return view('collections.collection', $data);
    }

}
