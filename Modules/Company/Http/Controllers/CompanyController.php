<?php

namespace Modules\Company\Http\Controllers;

use Activation;
use Sentinel;
use Illuminate\Support\Facades\Mail;
use Modules\UserManagement\Emails\AdminActivation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();

        try {
            $post = $request->all();

            $company = Company::create([
                'name' => $post['name'],
                'status' => $post['status'],
                'created_by_id' => loggedInUser('id')
            ]);

            // company role
            $role = Sentinel::findRoleById(3);

            if($role){
                $credentials = [
                    'email' => $post['email'],
                    'password' => time(),
                    'name' => $post['name'],
                    'phone' => !empty($post['phone']) ? $post['phone'] : '',
                    'address' => !empty($post['address']) ? $post['address'] : '',                
                    'created_by_id' => loggedInUser('id')
                ];
                
                $user = Sentinel::register($credentials);
                if($user){

                    $user->name = $post['name'];
                    $user->phone = $post['phone'];
                    $user->address = $post['address'];
                    $user->save();

                    $company->user_id = $user->id;
                    $company->save();

                    $role->users()->attach($user);
                    
                    // sentinel user activation
                    $activation = Activation::create($user);

                    // Send Email                
                    $params = [
                        'name' => $user->name,
                        'url' => route('activate.form', ['code' => $activation->code]),
                    ];

                    Mail::to($user)->send(new AdminActivation($params));
                    $request->session()->flash('message', __('usermanagement::admin.create_success'));
                }
            }

            DB::commit();
            
            $request->session()->flash('message', __('company::messages.create_success'));
            return redirect()->route('company.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
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
        DB::beginTransaction();
        try {
            $post = $request->all();
            $company->name = $post['name'];
            $company->status = $post['status'];
            $company->updated_by_id = loggedInUser('id');
            $company->save();

            $user = $company->user;
            $user->name = $post['name'];
            $user->phone = !empty($post['phone']) ? $post['phone'] : '';
            $user->address = !empty($post['address']) ? $post['address'] : '';            
            $user->updated_by_id = loggedInUser('id');
            $user->save();
            $request->session()->flash('message', __('company::messages.update_success'));

            DB::commit();
        }  catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('error', __('company::messages.update_failed'));
        }

        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Company $company,)
    {
        DB::beginTransaction();
        $success = true; 
        try {
            $company->delete();
            $company->user->delete();
            DB::commit();
        }  catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }
        return response()->json(['success'=> $success]);
        return redirect()->route('company.index');
    }
}
