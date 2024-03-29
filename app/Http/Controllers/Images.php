<?php

namespace App\Http\Controllers;
use App\Entities\Image;
use App\Entities\Fragment;
use App\Http\Requests;
use Illuminate\Http\Request;
use Config;

class Images extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        list($width, $height) = getimagesize($file);
        $mime = trim($file->getMimeType());
        // get filename
        $filename = str_replace([' ','+'],['-','-'],$file->getClientOriginalName());
        $last_dot = strrpos($filename, '.');
        $ext = substr($filename,$last_dot);
        $name = substr($filename,0, $last_dot);
        $filename = $name.'-'.md5(time().rand(0,999999)).$ext;


        $image = new Image([
            'slug'      => substr($filename,0,strpos($filename,'.')),
            'filename'  => $filename,
            'bytesize'  => filesize($file->getRealPath()),
            'width'     => isset($width) ? $width : 0,
            'height'    => isset($height) ? $height : 0,
        ]);
        // upload file
        $upload =
            $this->api(config('app.user_client'))->put(str_replace(env('FS_API_URL'),'',$image->link('upload')), fopen($file->getRealPath(), 'r'), [
                'Content-Type' => $mime,
            ], false);

        (new Fragment($request->get('fragment')))->attach($image);

        Config::set('laravel-debugbar::config.enabled', false);
        return response()->json($upload);
    }

    public function delete(Request $request, $id)
    {
        \Debugbar::disable();
        $image = (new Image($id))->delete();
        return response('success');
    }
}
