<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Entities\Role;
use Modules\UserManagement\Http\Requests\RoleRequest;
use Modules\UserManagement\Transformers\RoleResource;
use Sentinel;

class RoleController extends Controller
{
    public function index()
	{
		$roles = [];

		return view('usermanagement::role.index', ['roles'=>$roles]);
	}

	public function create()
	{
		return view('usermanagement::role.create');
	}

	public function edit(Role $role)
	{
		if(!$role){
			abort(404);
		}
		return view('usermanagement::role.edit', ['role'=>$role]);
	}

	public function list(Request $request){
		$allGet = $request->all();
        $data = [];
        $countTable = 0;
        $headerCode = 200;
        $returnErrors = null;
        
        try{
        	$columnIndex = $allGet['order'][0]['column'];
            $searchValue = $allGet['search']['value'];
            $startDate = $allGet['startDate'];
            $endDate = $allGet['endDate'];

        	$roleModel = Role::query();
            if($columnIndex == 0){
                $roleModel->orderBy('id' , $allGet['order'][0]['dir']);
            }else{
                $roleModel->orderBy( $allGet['columns'][$columnIndex]['data'] , $allGet['order'][0]['dir']);
            }
            if($searchValue){
                $roleModel->where('name', 'like', "%{$searchValue}%");
            }
            if($startDate && $endDate){
                $roleModel->whereRaw('DATE(created_at) BETWEEN ? AND ?',[$startDate,$endDate]);
            }
        	$countTable = $roleModel->count();
            $preData = $roleModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $data = RoleResource::collection($preData);
        } catch(\Exception $e){
            $returnErrors = [ ['field'=>'database', 'message'=>'Internal Server Error '.$e->getMessage()] ];
            $headerCode = 500;
        }

    	return response()->json(
			[
	            'data' => $data,
	            'draw' => $allGet['draw'],
				'recordsFiltered' => $countTable,
				'recordsTotal' => $countTable,
				'total_page' => ( (int) (20 / $allGet['length']) ),
                'old_start' => ((int) $allGet['start']),
                'errors' => $returnErrors,
	        ],
	        $headerCode
	    );
	}

	public function store(RoleRequest $request){		
        $post = $request->input();                    

        $role = Role::create([
            'slug' => $post['slug'],
            'name' => $post['name']             
        ]);

        $request->session()->flash('message', __('usermanagement::admin.create_success'));
        return redirect()->route('role.index');
        
	}

	public function update(Role $role, RoleRequest $request){
        $post = $request->input();                    
        
        $role->slug = $post['slug'];
        $role->name = $post['name'];
        $role->save();

        $request->session()->flash('message', __('usermanagement::admin.update_success'));
        return redirect()->route('role.index');
             
	}
    
    public function delete(Role $role, Request $request){
        $role->delete();

        $request->session()->flash('message', __('usermanagement::admin.delete_success'));
        return redirect()->route('role.index');
    
    }
}
