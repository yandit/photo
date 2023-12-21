<?php

namespace Modules\GoogleDriveMedia\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Transformers\CustomerResource;
use Modules\GoogleDriveMedia\Entities\Credential;
use Modules\GoogleDriveMedia\Entities\CredentialDetail;
use Modules\GoogleDriveMedia\Entities\Disk;

use Modules\GoogleDriveMedia\Http\Requests\CredentialRequest;
use Illuminate\Support\Facades\DB;

class CredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('googledrivemedia::credential.index');
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

            $customerModel = Customer::query();
            $customerModel = $customerModel->where('status', 'enable');
            if ($columnIndex == 0) {
                $customerModel->orderBy('id', $allGet['order'][0]['dir']);
            } else {
                $customerModel->orderBy($allGet['columns'][$columnIndex]['data'], $allGet['order'][0]['dir']);
            }
            
            if($name){
                $likeSearch = "%{$name}%";
                $customerModel->whereRaw(' ( name like ? ) ', [$likeSearch]);
            }
            if ($startDate && $endDate) {
                $customerModel->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }

            $countTable = $customerModel->count();
            $preData = $customerModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $data = CustomerResource::collection($preData);
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
        return view('googledrivemedia::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('googledrivemedia::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Customer $customer)
    {
        $credential = Credential::where('customer_id', $customer->id)->first();
        $disks = Disk::all();
        return view('googledrivemedia::credential.edit', compact('customer', 'credential', 'disks'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CredentialRequest $request, Customer $customer)
    {
        DB::beginTransaction();
        try {
            $post = $request->all();
            $credential = Credential::updateOrCreate(
                ['customer_id'=> $customer->id],
                [
                    'path'=> $post['path'], 
                    'created_by_id'=> loggedInUser('id'),
                    'updated_by_id'=> loggedInUser('id')
                ]
            );
            
            // if (!$request->input('disk_id')) {
            //     throw new \Exception('Minimum 1 API Credential');
            // }

            foreach ($request->input('disk_id') as $key => $value) {
                $credentialId = $request->input('id')[$key];

                $isDeleted = $request->input('is_deleted')[$key];
                // Buat atau perbarui data berdasarkan ID
                if($isDeleted == 'false'){
                    CredentialDetail::updateOrCreate(
                        ['id' => $credentialId],
                        [
                            'credential_id' => $credential->id,
                            'disk_id' => $request->input('disk_id')[$key],
                            'is_active' => $request->input('is_active')[$key]
                        ]
                    );
                }else{
                    CredentialDetail::where('id', $credentialId)->delete();
                }
            }
            
            DB::commit();

            $request->session()->flash('message', __('googledrivemedia::messages.update_success'));
            return redirect()->route('googledrivecredential.index');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            $message = $e->getMessage();
            $request->session()->flash('error', $message);
            DB::rollback();
        }
        
        return redirect()->route('googledrivecredential.edit', [
            'customer' => $customer
        ])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
