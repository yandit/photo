<?php

namespace App\Http\Controllers;

use App\Upload;
use App\Cart;
use Illuminate\Http\Request;
use Image;

use Storage;
use Illuminate\Http\Response;

// helper
use App\Http\Controllers\CloudinaryStorage;

// models
// use App\Upload;
use Modules\Customer\Entities\Customer;
use Modules\GoogleDriveMedia\Entities\SessionWhitelist;
use Modules\Frames\Entities\StickableFrame;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug=null)
    {
        $cart = cart();

        $selected_frame = $cart->frames_stickable;

        $frames = StickableFrame::where('status', 'publish')->get();
        $session_id = session()->getId();

        $uploads = Upload::whereHas('cart', function ($query) use ($session_id) {
            $query->where([
                'session_id'=> $session_id,
                'status'=> 'on-progress'
            ]);
        })->get();

        $session_whitelist = false;

        $all_files = [];
        
        if ($slug){
            $customer = Customer::where('slug', $slug)->first();
            $credential = $customer->credential;

            // get session whitelist
            $session_whitelist = $this->get_session_whitelist($credential);

            $all_files = $this->get_all_gdrive_files($slug, $credential);
        }

        return view('upload.index', compact('cart', 'frames', 'selected_frame', 'uploads', 'all_files', 'slug', 'session_whitelist'));
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
        $cart = cart();

        $images  = $request->file('images');
        foreach($images as $image){
            // $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName()); 

            $make = Image::make($image);
            $make->orientate();
            $height = $make->height();
            $width = $make->width();

            $square = ($width > $height) ? $height : $width;

            $imageName = time().'.'.$image->extension();

            $dateFolder = now()->format('Y-m-d');

            // Simpan gambar ke penyimpanan lokal menggunakan Storage
            $path = "public/uploads/$cart->session_id/$dateFolder";
            $imageUrl = \Storage::putFile($path, $image);
            // $imageUrl = \Storage::url($upload);
            Upload::create([
                'source'=> 'local',
                'cart_id'=> $cart->id,
                'image' => trim($imageUrl, '/'),
                'width' => $square,
                'height' => $square
            ]);
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
        $success = true;
        $errorMessage = '';

        try {
            $isAllowed = $this->isAllowedToManipulatedImage($upload);

            if(!$isAllowed){
                throw new \Exception('Session IDs do not match');
            }

            $x = $request->input('x');
            $y = $request->input('y');
            $w = $request->input('w');
            $h = $request->input('h');

            $cleft = $request->input('cleft');
            $ctop = $request->input('ctop');
            $cwidth = $request->input('cwidth');
            $cheight = $request->input('cheight');

            $upload->update([
                'x'=> $x,
                'y'=> $y,
                'width'=> $w,
                'height'=> $h,
                'cleft'=> $cleft,
                'ctop'=> $ctop,
                'cwidth'=> $cwidth,
                'cheight'=> $cheight,
            ]);

            $errorMessage = 'Resource updated successfully';

        } catch (\Exception $e) {
            // Catch the exception and set $success to false
            $success = false;
            $errorMessage = $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $errorMessage,
            'upload'=> $upload
        ]);
    }

    /**
     * checking whether or not the user is allowed to manipulated the image.
     * by comparing the cart session_id and the current user session_id
     *
     * @param  \App\Upload  $upload
     * @return boolean
     */
    public function isAllowedToManipulatedImage($upload)
    {
        $isAllowed = true;
        $uploadCartSessionId = $upload->cart->session_id;
        $currentSessionId = session()->getId();

        if ($uploadCartSessionId != $currentSessionId) {
            $isAllowed = false;
        }

        return $isAllowed;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {

        try {
            $isAllowed = $this->isAllowedToManipulatedImage($upload);

            if(!$isAllowed){
                throw new \Exception('Session IDs do not match');
            }

            $filePath = $upload->image;
            $upload->delete();
            if (\Storage::exists($filePath)) {
                \Storage::delete($filePath);
            }

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        }

        return redirect()->back();
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
