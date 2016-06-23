<?php

namespace App\Http\Controllers;

use App\Services\Api\PageService;
use App\Services\Api\FragmentService;
use App\Services\Api\CollectionService;
use App\Services\Api\ImageService;

use Illuminate\Http\Request;
use App\Http\Requests;

class Images extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $filename = str_replace([' ','+'],['-','-'],$file->getClientOriginalName());
        list($width, $height) = getimagesize($file);
        $mime = trim($file->getMimeType());

        $image = (new ImageService)->create([
            'slug'      => substr($filename,0,strpos($filename,'.')),
            'filename'  => $filename,
            'bytesize'  => filesize($file->getRealPath()),
            'width'     => isset($width) ? $width : 0,
            'height'    => isset($height) ? $height : 0,
        ]);
        // deal with file info errors
        if(isset($image['message'])){
            return back()->with([
                'status'            => 'Uploading image failed: '.$image['message'],
                'type'              => 'error',
            ]);
        }

        // upload file
        $upload =
            $this->api($this->client)->put($image['data']['links']['upload'], fopen($file->getRealPath(), 'r'), [
                'Content-Type' => $mime,
            ]);
        \Log::debug('-'.$mime.'-');
        \Log::debug('-'.trim($mime).'-');
        \Log::debug($upload);

        $response =
            $this->api($this->client)->post('/fragments/'.$request->get('fragment').'/relationships/images', [
                'type' => 'images',
                'id'   => $image['data']['id'],
        ]);

        (new PageService)->clearCache();
        (new CollectionService)->clearCache();
        (new FragmentService)->clearCache();

        return back();
    }
}
