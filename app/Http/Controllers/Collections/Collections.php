<?php

namespace App\Http\Controllers\Collections;

use Illuminate\Http\Request;
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
        ],
        'lists' => [[
            'add' => [
                'link' => '/collections/create'
            ],
            'items' => []
        ]]
    ];

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
