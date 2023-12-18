<?php

namespace Modules\GoogleDriveMedia\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Transformers\CustomerResource;
use Modules\GoogleDriveMedia\Entities\Credential;

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
                $customerModel->whereRaw('DATE(faqs.created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
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
        $credential = Credential::find($customer->id);
        return view('googledrivemedia::credential.edit', compact('customer', 'credential'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Customer $customer)
    {
        $post = $request->all();
        $credential = Credential::updateOrCreate(
            ['customer_id'=> $customer->id],
            [
                'path'=> $post['path'], 
                'created_by_id'=> loggedInUser('id'),
                'updated_by_id'=> loggedInUser('id')
            ]
        );

        $request->session()->flash('message', __('googledrivemedia::messages.update_success'));
        return redirect()->route('googledrivecredential.index');
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
