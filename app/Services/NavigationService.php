<?php

namespace App\Services;

use Illuminate\Http\Request;
use Config;

class NavigationService
{
    /**
     * $active menu item(s)
     *
     * @var array
     */
    protected $active = [
        'path'      => NULL,
        'section'   => NULL,
        'item'      => NULL,
        'sub_item'  => NULL,
    ];
    /**
     * constructor
     *
     * @method __construct
     *
     * @param  Request     $request
     */
    public function __construct(Request $request)
    {
        // only run in get requests
        if( app('request')->method() === 'GET' ){
            // get active path
            $this->active['path'] = '/'.trim(app('request')->path(),'/');
            view()->share('active_item', '/'.trim($this->active['path'],'/'));
            // active section
            if(!($this->active['section'] = app('request')->segment(1))){
                $this->active['section'] = 'dashboard';
            }
            // active item
            $this->active['item'] = app('request')->segment(2);
            // active sub item
            $this->active['sub_item'] = app('request')->segment(3);
        }
    }
    /**
     * get the rendered navigation view
     *
     * @method render
     *
     * @return View
     */
    public function render()
    {
        return view('navigation.menu', [
            'active'        => $this->active,
            'navigation'    => $this->getNav(),
        ]);
    }
    /**
     * build the navigation array
     *
     * @method getNavItems
     *
     * @return array
     */
    protected function getNav()
    {
        // get config
        $nav = Config::get('navigation');
        $lists = NULL;
        if(isset($nav['lists'][$this->active['section']])){
            $lists = $nav['lists'][$this->active['section']];
        }
        elseif(isset($nav['lists']['dashboard'])){
            $lists = $nav['lists']['dashboard'];
        }
        // return array
        return [
            'header' => $this->getHeader($nav['header']),
            'lists'  => $this->getLists($lists),
        ];
    }
    /**
     * get navigation header for each section
     *
     * @method getHeader
     *
     * @param  array    $headers [description]
     *
     * @return array
     */
    protected function getHeader($headers = NULL)
    {
        // try to get header from service
        if( method_exists($this, 'getHeader'.ucfirst($this->active['section'])) ){
            if($header = $this->{'getHeader'.ucfirst($this->active['section'])}()){
                return $header;
            }
        }
        // if header is set in settings
        if(isset($headers[$this->active['section']])){
            return $headers[$this->active['section']];
        }
        // return dashboard header
        return is_array($headers['dashboard']) ? $headers['dashboard'] : [];
    }
    /**
     * get navigation lists for each section
     *
     * @method getLists
     *
     * @param  array    $lists [description]
     *
     * @return array
     */
    protected function getLists($lists = NULL)
    {
        // try to get header from service
        if( method_exists($this, 'getList'.ucfirst($this->active['section'])) ){
            if($result = $this->{'getList'.ucfirst($this->active['section'])}($lists)){
                return $result;
            }
        }
        // return dashboard lists
        if( method_exists($this, 'getListDashboard') ){
            return $this->getListDashboard($lists);
        }
        // nothing is available
        return [];
    }
    /**
     * build the lists for dashboard
     *
     * @method getListDashboard
     *
     * @param  Array           $lists [description]
     *
     * @return Array
     */
    protected function getListDashboard($lists = NULL){
        foreach($lists as $key => $list){
            if($list['items'] === '$collections'){
                $lists[$key] = array_merge($lists[$key], [
                    'items' => config('app.user')->account()->collections(),
                    'elements' => [
                        view('navigation.item', [
                            'label'     => 'New Collection',
                            'icon'      => 'plus',
                            'attr'      => 'data-dialog-link=/dialog/newCollection',
                        ])->render()
                    ]
                ]);
            }
        }
        // return
        return $lists;
    }
    /**
     * build the lists for pages
     *
     * @method getListPages
     *
     * @param  Array           $lists [description]
     *
     * @return Array
     */
    protected function getListPages($lists = NULL){
        // get lists
        $items = config('app.user')->account()->navigation()->sortBy('position');
        // prepare lists
        $lists = [];
        foreach($items as $key => $list){

            $lists[$key] = [
                'title'             => $list->get('name'),
                'collection_id'     => $list->get('id'),
                'patch_url'         => '/pages',
                'items'             => $list->pages()->map(function($item){
                    return $item->put('collection', 'pages');
                }),
                'template'    => 'navigation.item-page',
                'elements' => [
                    view('navigation.add', [
                        'action'    => '/pages',
                        'method'    => 'post',
                        'label'     => 'New Page'
                    ])->render()
                ]
            ];
        }
        // add navigation collection
        // $lists[] = ['elements' => [
        //     view('navigation.add', [
        //         'action'    => '/pages',
        //         'method'    => 'post',
        //         'label'     => 'New Navigation'
        //     ])->render()
        // ]];

        // return
        return $lists;
    }
    /**
     * build the lists for Collections
     *
     * @method getListCollections
     *
     * @param  Array           $lists [description]
     *
     * @return Array
     */
    protected function getListCollections($lists = NULL){
        // get lists
        $collection = config('app.user')->account()->collections('slug',$this->active['item'],true);
        // return false if no pages exists
        if($collection->pages()->isEmpty()){
            return NULL;
        }
        // return
        return [
            [
                'items'     => $collection->pages(),
                'template'  => 'navigation.item-page',
                'elements' => [
                    view('navigation.add', [
                        'action'    => '/pages',
                        'method'    => 'post',
                        'label'     => 'New Page',
                        'fields'    => [
                            'collection' => $collection->get('id')
                        ]
                    ])->render()
                ]
            ]
        ];
    }
    /**
     * build header for collections
     *
     * @method getHeaderCollections
     *
     * @return Array
     */
    public function getHeaderCollections()
    {
        $item = config('app.user')->account()->collections('slug',$this->active['item'],true);
        // return false if no pages exists
        if($item->pages()->isEmpty()){
            return false;
        }
        // if pages are set
        return view('navigation.header-collection', [
            'item' => $item
        ])->render();
    }
}
