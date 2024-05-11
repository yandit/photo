<?php

namespace Modules\GoogleDriveMedia\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GoogleDriveMedia\Entities\Credential;
use Modules\GoogleDriveMedia\Transformers\GalleryResource;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('googledrivemedia::gallery.index');
    }

    public function list(Request $request)
    {
        $allGet = $request->all();
        $data = [];
        $countTable = 0;
        $headerCode = 200;
        $returnErrors = null;

        try {
            $columnIndex = $allGet['order'][0]['column'];
            $searchValue = $allGet['search']['value'];
            $startDate = $allGet['startDate'];
            $endDate = $allGet['endDate'];
            $name = $allGet['name'];

            $credentialModel = Credential::query();
            $credentialModel->join('customers', 'credentials.customer_id', '=', 'customers.id');
            $company = loggedInUser('company');
            if($company){
                $credentialModel = $credentialModel->where(['company_id'=> $company->id]);
            }
            if ($columnIndex == 0) {
                $credentialModel->orderBy('credentials.id', $allGet['order'][0]['dir']);
            } else {
                // dd($allGet['columns']);
                if($allGet['columns'][$columnIndex]['data'] == 'name'){
                    $allGet['columns'][$columnIndex]['data'] = 'customers.name';
                }
                $credentialModel->orderBy($allGet['columns'][$columnIndex]['data'], $allGet['order'][0]['dir']);
            }
            
            if($name){
                $likeSearch = "%{$name}%";
                $credentialModel->whereRaw('(customers.name LIKE ?)', ["%{$likeSearch}%"]);
            }
            if ($startDate && $endDate) {
                $credentialModel->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }

            $countTable = $credentialModel->count();
            $preData = $credentialModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $data = GalleryResource::collection($preData);
        } catch (\Exception $e) {
            $returnErrors = [['field' => 'database', 'message' => 'Internal Server Error ' . $e->getMessage()]];
            $headerCode = 500;
        }

        return response()->json(
            [
                'data' => $data,
                'draw' => $allGet['draw'],
                'recordsFiltered' => $countTable,
                'recordsTotal' => $countTable,
                'old_start' => ((int) $allGet['start']),
                'errors' => $returnErrors,
            ],
            $headerCode
        );
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Credential $credential)
    {
        return view('googledrivemedia::gallery.create', compact('credential'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, Credential $credential)
    {
        $active_credential = $credential->credential_details->where('is_active', true)->first();
        $disk_name = $active_credential->disk->disk_name;

        $files = $request->file('image');

        foreach ($files as $file) {
            $uniqueFileName = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
            $path = "{$credential->path}/{$uniqueFileName}";
            \Storage::disk($disk_name)->put($path, file_get_contents($file));
        }

        return redirect()->route('googledrivegallery.edit', ['credential'=> $credential]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('googledrivemedia::gallery.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Credential $credential)
    {
        $all_files = [];
        foreach ($credential->credential_details as $key => $detail) {
            $files = \Storage::disk($detail->disk->disk_name)->listContents($credential->path, false);

            foreach ($files as &$file) {
                $file['disk_name'] = $detail->disk->disk_name;
            }
            
            unset($file);
            $all_files = array_merge($all_files, $files);
        }
        
        return view('googledrivemedia::gallery.edit', compact('credential', 'all_files'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Request $request, Credential $credential)
    {
        $path = $request->query('path');
        $disk_name = $request->query('disk_name');

        \Storage::disk($disk_name)->delete($path);
        return redirect()->back();
    }
}
