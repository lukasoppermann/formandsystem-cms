<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;

class ApiAccess extends Settings
{

    public function show(Request $request){
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/'.$request->segment(2));
        $data['client_id'] = $request->user()->accounts->first()->client_id;

        return view('settings.api-access', $data);
    }

    public function store(Request $request){
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/'.$request->segment(2));
        $data['credentials'] = $this->generateApiAccess();
        $data['client_id'] = $data['credentials']['client_id'];

        return redirect('settings/api-access')->with('status', 'Profile updated!');
        return view('settings.api-access', $data);
    }




}
