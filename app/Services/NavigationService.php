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
            'navigation'    => $this->getNavItems(),
        ]);
    }
    /**
     * build the navigation array
     *
     * @method getNavItems
     *
     * @return array
     */
    protected function getNavItems()
    {
        // get config
        $nav = Config::get('navigation');
        // preset header & lists
        $header = $nav['header']['dashboard'];
        $lists = $nav['lists']['dashboard'];
        // get header
        if(isset($nav['header'][$this->active['section']])){
            $header = $nav['header'][$this->active['section']];
        }
        // get lists
        if( isset($nav['lists'][$this->active['section']]) ){
            $lists = $nav['lists'][$this->active['section']];
        }
        // return array
        return [
            'header' => $header,
            'lists'  => $this->prepareItems($lists),
        ];
    }
    /**
     * call function to get items if not preset as array
     *
     * @method prepareItems
     *
     * @param  Array       $lists [description]
     *
     * @return Array
     */
    protected function prepareItems($lists)
    {
        foreach($lists as $key => $list){
            if( !is_array($list['items']) ){
                $lists[$key] = (new \App\Services\Api\CollectionService)->navigation($this->active['item']);
            }
        }
        // return prepared lists array
        return $lists;
    }
}
