<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\ApiImageService;

class Images extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $filename = str_replace([' ','+'],['-','-'],$file->getClientOriginalName());
        list($width, $height) = getimagesize($file);
        $mime = $file->getMimeType();

        $image = (new ApiImageService)->create([
            'slug'      => substr($filename,0,strpos($filename,'.')),
            'filename'  => $filename,
            'bytesize'  => filesize($file->getRealPath()),
            'width'     => $width,
            'height'    => $height,
        ]);
        $upload =
            $this->api($this->client)->put($image['data']['links']['upload'], fopen($file->getRealPath(), 'r'), [
                'Content-Type' => $mime
            ]);
        
        $response =
            $this->api($this->client)->post('/fragments/'.$request->get('fragment').'/relationships/images', [
                'type' => 'images',
                'id'   => $image['data']['id'],
        ]);

        return back();
    }
}
