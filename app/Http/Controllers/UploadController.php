<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;

use Storage;
use Illuminate\Http\Response;

// helper
use App\Http\Controllers\CloudinaryStorage;

// models
// use App\Upload;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uploads = Upload::get();

        $files = Storage::disk('google')->listContents('/lokasi a/', false);
        return view('upload.index', compact('uploads', 'files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $images  = $request->file('images');
        foreach($images as $image){
            $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName()); 
            Upload::create(['image' => $result]);
        }
        return redirect()->route('upload.index')->withSuccess('berhasil upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
        //
    }

    public function getImage($filename)
    {
        $file = Storage::disk('google')->get($filename);
        
        return new Response($file, 200, [
            'Content-Type' => 'image/jpeg', // Ganti tipe mime sesuai dengan tipe gambar yang diinginkan
            'Content-Disposition' => 'inline',
        ]);
    }
}
