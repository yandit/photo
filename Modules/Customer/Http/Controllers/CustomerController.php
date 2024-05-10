<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Transformers\CustomerResource;
use Modules\Customer\Http\Requests\CustomerRequest;

use Modules\Company\Entities\Company;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('customer::index');
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
            $status = $allGet['status'];

            $faqModel = Customer::query();
            if ($columnIndex == 0) {
                $faqModel->orderBy('id', $allGet['order'][0]['dir']);
            } else {
                $faqModel->orderBy($allGet['columns'][$columnIndex]['data'], $allGet['order'][0]['dir']);
            }
            
            if($name){
                $likeSearch = "%{$name}%";
                $faqModel->whereRaw(' ( name like ? ) ', [$likeSearch]);
            }
            if($status){
                $faqModel->where('status', $status);
            }
            if ($startDate && $endDate) {
                $faqModel->whereRaw('DATE(customers.created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }

            $countTable = $faqModel->count();
            $preData = $faqModel
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
        $companies = Company::all();
        return view('customer::create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CustomerRequest $request)
    {
        $post = $request->all();
        Customer::create([
            'name' => $post['name'],
            'slug' => $post['slug'],
            'company_id' => $post['company'],
            'status' => $post['status'],
            'created_by_id' => loggedInUser('id')
        ]);
        $request->session()->flash('message', __('customer::messages.create_success'));
        return redirect()->route('customer.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('customer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Customer $customer)
    {
        $companies = Company::all();
        return view('customer::edit', compact('customer', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Customer $customer, CustomerRequest $request)
    {
        $post = $request->all();
        $customer->name = $post['name'];
        $customer->slug = $post['slug'];
        $customer->status = $post['status'];
        $company_id = @$post['company'] || loggedInUser('company')->id;
        $customer->company_id = $company_id;
        $customer->updated_by_id = loggedInUser('id');
        $customer->save();

        $request->session()->flash('message', __('customer::messages.update_success'));
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Customer $customer,)
    {
        $customer->delete();
        return redirect()->route('customer.index');
    }
}
