<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class GetImageController extends Controller
{
    public function crop($x, $y, $w, $h, $path)
    {
        $x = $x == 'null' ? null : $x;
        $y = $y == 'null' ? null : $y;

        $img = Image::cache(function($image) use($x, $y, $w, $h, $path) {
            $image->make($path)
                ->orientate()
                ->crop($w, $h, $x, $y)
                ->resize(472, 472)
                ->encode('jpg',60);
        }, 1000, true);

        return $img->response();
    }
}
