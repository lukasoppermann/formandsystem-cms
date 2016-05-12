<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class ApiAccess extends Settings
{

    public function show(Request $request){
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/'.$request->segment(2));

        return view('settings.api-access', $data);
    }

    public function generateApiAccess(){
        return $this->api()->get('/images');
    }
}
