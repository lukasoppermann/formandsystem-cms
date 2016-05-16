<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;

class Site extends Settings
{

    public function show(){
        // overwrite $page with site
        $page = 'site';
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/'.$page);

        return view('settings.'.$page, $data);
    }
}
