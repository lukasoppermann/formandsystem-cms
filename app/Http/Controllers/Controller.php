<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected function buildNavigation($active = false){
        // get navigation array to not change original
        $navigation = $this->navigation;
        // set active item active
        if($active !== false){
            foreach($navigation['lists'] as $key => $list){
                if( ($found = array_search($active, array_column($list['items'], 'link'))) !== false ){
                    $navigation['lists'][$key]['items'][$found]['is_active'] = true;
                }
            }
        }
        return $navigation;
    }
}
