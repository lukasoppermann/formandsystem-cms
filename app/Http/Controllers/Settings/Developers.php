<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class Developers extends Settings
{

    public function show(){
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/developers');

        return view('settings.developers', $data);
    }

}
