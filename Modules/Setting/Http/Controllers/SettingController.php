<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Controller;
use Modules\Setting\Facades\SettingFacade;

use Modules\Setting\Entities\SettingModel;
use Modules\Setting\Http\Requests\SettingAllRequest;
use Modules\Setting\Http\Requests\SettingRequest;
use File;
use Storage;

class SettingController extends Controller
{		

	public function index()
	{
        #Setting::setting('admin.title');        
        $settingModel = SettingModel::get();
        $settings = [];
        foreach($settingModel as $setting){
            $settings[$setting->group][] = $setting;
        }

		return view('setting::index', [            
            'groups' => config('setting.group'),
            'settings' => $settings,
            'setting_types' => config('setting.setting_types'),
        ]);
	}

	public function store(SettingRequest $request){
        $post = $request->input();
        SettingModel::create([
            'key' => $this->transformKey($post['group'],$post['key']),
            'name' => $post['name'],
            'type' => $post['type'],
            'group' => $post['group'],
        ]);
        $request->session()->flash('message', __('setting::messages.create_success'));
        return redirect()->route('setting.view');    
	}

    private function transformKey($group, $value){
        return strtolower(str_replace(' ', '_', $group)).'.'.$value;
    }


	public function update(SettingAllRequest $request){
        $settings = SettingModel::get();
        $post = $request->all();
        $postSettings = $post['settings'];
        foreach($settings as $setting){                
            $value = '';
            if($setting->type == 'image'){
                $value = $setting->value;
            }            
            if(isset($postSettings[$setting->id])){
                $value = $postSettings[$setting->id];
                if($setting->type == 'image'){                        
                    if ($postSettings[$setting->id]->isValid()) {
                        $date = strtotime(date('Y-m'));
                        $image = $postSettings[$setting->id]->store('public/settings/'.$date);
                        if($image){
                            $value = $image;                                
                            Storage::delete($setting->value);
                        }
                    }
                }
            }
            $setting->value = $value;
            $setting->save();

            // do empty cache
            SettingFacade::forgetSetting();
        }

        $request->session()->flash('message', __('setting::messages.update_success'));
        return redirect()->route('setting.view');        
	}
    
    public function delete($id, Request $request){
        $setting = SettingModel::find($id);
        if(!$setting){
            abort(404);
        }else{
            if($setting->is_deletable == 'no'){
                $request->session()->flash('error', 'Cannot delete default app value');
            }else{
                $setting->delete();
                $request->session()->flash('message', __('setting::messages.delete_success'));
            }
            
            return redirect()->route('setting.view');
        }
    }
}
