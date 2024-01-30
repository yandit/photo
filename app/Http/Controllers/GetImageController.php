<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class GetImageController extends Controller
{
    public function crop($source, $x, $y, $w, $h, $path)
    {
        $x = $x == 'null' ? null : (int)$x;
        $y = $y == 'null' ? null : (int)$y;

        $img = Image::cache(function($image) use($x, $y, $w, $h, $path, $source) {
            $path = $this->handlePath($source, $path);
            
            $image->make($path)
                ->orientate()
                ->crop((int)$w, (int)$h, $x, $y)
                ->resize(472, 472)
                ->encode('jpg',60);
        }, 1000, true);

        return $img->response();
    }

    protected function handlePath($source, $path)
    {
        if($source == 'local'){
            $path = \Storage::url($path);
            $path = trim($path, '/');
        }

        return $path;
    }
}
