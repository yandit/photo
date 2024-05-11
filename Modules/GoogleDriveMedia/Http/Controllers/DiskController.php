<?php

namespace Modules\GoogleDriveMedia\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GoogleDriveMedia\Entities\Disk;

use Modules\GoogleDriveMedia\Transformers\DiskResource;
use Modules\GoogleDriveMedia\Http\Requests\DiskRequest;

use Modules\Company\Entities\Company;

class DiskController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('googledrivemedia::disk.index');
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
            $disk_name = $allGet['disk_name'];

            $diskModel = Disk::query();
            $company = loggedInUser('company');
            if($company){
                $diskModel = $diskModel->where(['company_id'=> $company->id, 'type'=> 'private']);
            }
            
            if ($columnIndex == 0) {
                $diskModel->orderBy('id', $allGet['order'][0]['dir']);
            } else {
                $diskModel->orderBy($allGet['columns'][$columnIndex]['data'], $allGet['order'][0]['dir']);
            }
            
            if($disk_name){
                $likeSearch = "%{$disk_name}%";
                $diskModel->whereRaw(' ( disk_name like ? ) ', [$likeSearch]);
            }
            if ($startDate && $endDate) {
                $diskModel->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }

            $countTable = $diskModel->count();
            $preData = $diskModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $data = DiskResource::collection($preData);
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
    public function create()
    {
        $companies = Company::all();
        return view('googledrivemedia::disk.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(DiskRequest $request)
    {
        $post = $request->all();
        Disk::create([
            'disk_name' => $post['disk_name'],
            'email' => $post['email'],
            'company_id' => @$post['company'] ?? @loggedInUser('company')->id,
            'type' => @$post['type'] ?? 'private',
            'password' => $post['password'],
            'client_id' => $post['client_id'],
            'client_secret' => $post['client_secret'],
            'refresh_token' => $post['refresh_token'],
            'created_by_id' => loggedInUser('id')
        ]);
        $request->session()->flash('message', __('googledrivemedia::messages.create_success'));
        return redirect()->route('googledrivedisk.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('googledrivemedia::disk.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Disk $disk)
    {
        $companies = Company::all();
        return view('googledrivemedia::disk.edit', compact('disk', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(DiskRequest $request, Disk $disk)
    {
        $post = $request->all();
        $disk->disk_name = $post['disk_name'];
        $disk->email = $post['email'];
        $disk->password = $post['password'];
        $company_id = @$post['company'] ?? @loggedInUser('company')->id;
        $disk->company_id = $company_id;
        $type = @$post['type'] ?? 'private';
        $disk->type = $type;
        $disk->client_id = $post['client_id'];
        $disk->client_secret = $post['client_secret'];
        $disk->refresh_token = $post['refresh_token'];
        $disk->updated_by_id = loggedInUser('id');
        $disk->save();

        $request->session()->flash('message', __('googledrivemedia::messages.update_success'));
        return redirect()->route('googledrivedisk.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Disk $disk, Request $request)
    {
        $success = true;
        try {
            $disk->delete();
        } catch (\Exception $e) {
            $success = false;
        }
        return response()->json([
            'success'=> $success
        ]);
    }
}
