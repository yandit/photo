<?php

namespace Modules\UserManagement\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

class UserManagementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Sentinel::check();
        $route = $request->route()->getAction();                
        if(!$user){
            return redirect()->route('admin.login');
        }
        $permissionExceptions = config('usermanagement.permission_exceptions');
        $accessException = in_array($route['as'],$permissionExceptions);
        if ( (isset($route['as'])) ){
            $as = $route['as'];
            // dd($user->hasAccess(['admin.profile']));
            if(!$user->hasAccess([$as]) && !$accessException){
                abort(403, 'Forbidden');
            }                    
        } 

        return $next($request);
    }
}
