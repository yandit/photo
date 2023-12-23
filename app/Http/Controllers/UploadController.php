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
use Modules\Customer\Entities\Customer;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug=null)
    {
        $uploads = Upload::get();
        $all_files = [];

        if($slug){
            $customer = Customer::where('slug', $slug)->first();
            $credential = $customer->credential;
            $path = $credential->path;
            foreach ($credential->credential_details as $key => $detail) {
                $disk_name = $detail->disk->disk_name;
                $files = Storage::disk($disk_name)->listContents($path, false);   

                foreach ($files as &$file) {
                    $file['disk_name'] = $detail->disk->disk_name;
                }
                
                unset($file);
                $all_files = array_merge($all_files, $files);
            }
        }
        return view('upload.index', compact('uploads', 'all_files', 'slug'));
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
    public function store(Request $request, $slug=null)
    {
        $images  = $request->file('images');
        foreach($images as $image){
            $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName()); 
            Upload::create(['image' => $result]);
        }
        return redirect()->route('upload.index', ['slug'=> $slug])->withSuccess('berhasil upload');
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

    public function getImage(Request $request)
    {
        $path = $request->query('path');
        $disk_name = $request->query('disk_name');
        $file = Storage::disk($disk_name)->get($path);
        
        return new Response($file, 200, [
            'Content-Type' => 'image/jpeg', // Ganti tipe mime sesuai dengan tipe gambar yang diinginkan
            'Content-Disposition' => 'inline',
        ]);
    }
}
