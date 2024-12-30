<?php

namespace App\Http\Middleware;

use App\Models\UserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PermissionMiddleware
{

    public function handle(Request $request, Closure $next,$parameter)
    {
        $user = Auth::user();
        if ($parameter == '' || $user->is_root == 'yes'){
            return $next($request);
        }

        $userPermission = new UserPermission();

        $check = $userPermission->checkPagePermision($user->id,$parameter);
        if($check == null){
            abort(403);
        }

        return $next($request);
    }
}
