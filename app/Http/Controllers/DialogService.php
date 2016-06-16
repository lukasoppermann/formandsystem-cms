<?php

namespace App\Http\Controllers;

use App\Services\Api\CollectionService;
use Illuminate\Http\Request;

class DialogService extends Controller
{
    public function show(Request $request, $type)
    {
        return $this->{'dialog'.ucfirst($type)}($request);
    }

    protected function dialogEditCollection(Request $request)
    {
        $collection = (new CollectionService)->get($request->get('id'));
        if($collection !== NULL){
            return view('notice.dialog.edit-collection', $collection->toArray())->render();
        }
        return false;
    }

    protected function dialogNewCollection(Request $request)
    {
        return view('notice.dialog.new-collection')->render();
    }
}
