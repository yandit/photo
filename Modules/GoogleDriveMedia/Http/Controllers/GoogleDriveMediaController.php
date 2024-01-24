<?php

namespace Modules\GoogleDriveMedia\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Image;

class GoogleDriveMediaController extends Controller
{
    public function getGoogleDriveImage(Request $request)
    {
        $path = $request->query('path');
        $disk_name = $request->query('disk_name');

        return Cache::remember($path, 1000, function() use($disk_name, $path){
            $file = Storage::disk($disk_name)->get($path);    
            return new Response($file, 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'inline',
            ]);
        });
    }
}
