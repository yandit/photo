<?php

if(!function_exists('setMenuSession')){
    function setMenuSession($role){
        $menus = config('menus');
        $menus = collect($menus);
        $menus = $menus->sortBy('order');
        
        $permissions = ($role) ? $role->permissions : [];
        $myMenus = [];
        foreach($menus as $menu){
            if(isset($menu['subs']) && $menu['subs']){
                $ngsubs = [];
                foreach($menu['subs'] as $k=>$v){
                    if(isset($permissions[$v['permission']]) && $permissions[$v['permission']]){
                        $ngsubs[] = $v;
                    }
                }
    
                if($ngsubs){
                    $menu['subs'] = $ngsubs;
                    $myMenus[] = $menu;
                }
            }else{
                if(isset($permissions[$menu['permission']]) && $permissions[$menu['permission']]){
                    $myMenus[] = $menu;
                }
            }
        }
    
        session(['menus' => $myMenus]);  
    }
}

if(!function_exists('loggedInUser')){
    function loggedInUser($key){
        return \Sentinel::getUser()[$key];
    }
}