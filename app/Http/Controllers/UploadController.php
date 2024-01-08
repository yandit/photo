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
use Modules\GoogleDriveMedia\Entities\SessionWhitelist;

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
        
        echo session()->getId();

        $session_whitelist = false;

        $session_id = session()->getId();
        if ($slug){
            $customer = Customer::where('slug', $slug)->first();
            $credential = $customer->credential;

            // get session whitelist
            $session_whitelist = $this->get_session_whitelist($credential);

            $all_files = $this->get_all_gdrive_files($slug, $credential);
        }

        return view('upload.index', compact('uploads', 'all_files', 'slug', 'session_whitelist'));
    }

    /**
     * get all files from google drive.
     *
     * @return array
     */
    private function get_all_gdrive_files($slug, $credential)
    {

        $all_files = [];

        if ($slug){
            // get session whitelist
            $session_whitelist = $this->get_session_whitelist($credential);

            if($session_whitelist){
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
        }
        
        return $all_files;
    }

    /**
     * check is the session is stored in db after inputing pin.
     *
     * @return SessionWhitelist
     */
    private function get_session_whitelist($credential)
    {
        $session_id = session()->getId();
        $session_whitelist = SessionWhitelist::where(['credential_id'=> $credential->id, 'session_id'=> $session_id])->first();
        return $session_whitelist;
    }

    public function pin_check(Request $request)
    {
        $slug = $request->input('slug');
        $pin = $request->input('pin');
        $customer = Customer::where('slug', $slug)->first();
        $credential = $customer->credential->where('pin', $pin)->first();

        if(!$credential){
            $messages = 'credential not found';
            $success = false;

        }else{
            $messages = 'success';
            $success = true;

            $session_id = session()->getId();

            $session_whitelist = new SessionWhitelist;
            $session_whitelist->session_id = $session_id;
            $session_whitelist->credential_id = $credential->id;
            $session_whitelist->save();
        }

        return response()->json([
            'success'=> $success,
            'messages'=> $messages
        ]);
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
