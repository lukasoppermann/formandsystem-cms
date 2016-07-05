<?php

namespace App\Services;

use App\Services\Api\FragmentService;
use App\Services\Api\CollectionService;
use Illuminate\Http\Request;

class DialogService extends AbstractService
{
    public function show(Request $request, $type)
    {
        \Config::set('user.grid-sm',2);
        \Config::set('user.grid-md',12);
        \Config::set('user.grid-lg',16);

        return $this->{'dialog'.ucfirst($type)}($request);
    }

    protected function dialogEditCollection(Request $request)
    {
        $collection = new \App\Entities\Collection($request->get('id'));
        if($collection !== NULL){
            return view('notice.dialog.edit-collection', $collection->toArray())->render();
        }
        return false;
    }

    protected function dialogNewCollection(Request $request)
    {
        return view('notice.dialog.new-collection')->render();
    }

    protected function dialogFragmentSettings(Request $request)
    {
        return view('notice.dialog.fragment-settings', [
            'item' => new \App\Entities\Fragment($request->get('id'))
        ])->render();
    }
}
