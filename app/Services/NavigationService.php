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
            $header = $this->{'getHeader'.ucfirst($this->active['section'])}();
            if(is_array($header) && isset($header['title'])){
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
                    'items' => (new \App\Services\Api\CollectionService)->find('type','posts', [
                        'only' => false
                    ]),
                    'elements' => [
                        view('navigation.add', [
                            'action'    => '/collections',
                            'method'    => 'post',
                            'label'     => 'Add Collection'
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
        $items = (new \App\Services\Api\CollectionService)->find('type','navigation', [
            'only' => 'pages'
        ]);
        // prepare lists
        $lists = [];
        foreach($items as $key => $list){
            $lists[$key] = [
                'title'       => $list->name,
                'items'       => $list->pages,
                'template'    => 'navigation.item-page',
                'elements' => [
                    view('navigation.add', [
                        'action'    => '/pages',
                        'method'    => 'post',
                        'label'     => 'Add Page'
                    ])->render()
                ]
            ];
        }
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
        $items = (new \App\Services\Api\CollectionService)->first('slug',$this->active['item'], [
            'only' => 'pages'
        ]);
        // return false if no pages exists
        if($items->pages->isEmpty()){
            return NULL;
        }
        // return
        return [
            [
                'items'     => $items->pages,
                'template'  => 'navigation.item-page'
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
        $items = (new \App\Services\Api\CollectionService)->first('slug',$this->active['item'], [
            'only' => 'pages'
        ]);
        // return false if no pages exists
        if($items->pages->isEmpty()){
            return false;
        }
        // if pages are set
        return [
            'title' => $items->name,
            'link'  => '/',
        ];
    }
}
