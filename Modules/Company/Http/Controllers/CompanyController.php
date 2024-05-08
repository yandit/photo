<?php

namespace Modules\Company\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Company\Entities\Company;
use Modules\Company\Transformers\CompanyResource;
use Modules\Company\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('company::index');
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

            $faqModel = Company::query();
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
                $faqModel->whereRaw('DATE(companies.created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }

            $countTable = $faqModel->count();
            $preData = $faqModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $data = CompanyResource::collection($preData);
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
        return view('company::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CompanyRequest $request)
    {
        $post = $request->all();
        Company::create([
            'name' => $post['name'],
            'status' => $post['status'],
            'created_by_id' => loggedInUser('id')
        ]);
        $request->session()->flash('message', __('company::messages.create_success'));
        return redirect()->route('company.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('company::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Company $company)
    {
        return view('company::edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Company $company, CompanyRequest $request)
    {
        $post = $request->all();
        $company->name = $post['name'];
        $company->status = $post['status'];
        $company->updated_by_id = loggedInUser('id');
        $company->save();

        $request->session()->flash('message', __('company::messages.update_success'));
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Company $company,)
    {
        $company->delete();
        return redirect()->route('company.index');
    }
}
