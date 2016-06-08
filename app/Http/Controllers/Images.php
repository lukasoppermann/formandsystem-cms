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

        $filename = 'Test.png';
        $width = $height = 2;
        // $filename = str_replace([' ','+'],['-','-'],$file->getClientOriginalName());
        // list($width, $height) = getimagesize($file);
        $mime = $file->getMimeType();

        $image = (new ApiImageService)->create([
            'slug'      => substr($filename,0,strpos($filename,'.')),
            'filename'  => $filename,
            'bytesize'  => 1,
            'width'     => $width,
            'height'    => $height,
        ]);
        $upload =
            $this->api($this->client)->put($image['data']['links']['upload'], fopen($file->getRealPath(), 'r'), [
                'Content-Type' => $mime
            ]);
        dd($upload);
        $response =
            $this->api($this->client)->post('/fragments/'.$request->get('fragment').'/relationships/images', [
                'type' => 'images',
                'id'   => $image['data']['id'],
        ]);

        return back();
    }
}
