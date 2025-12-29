<?php

namespace App\Http\Middleware;

use App\Models\Admin\AdminMenu;
use App\Models\Admin\AdminUserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $menuName, $action, $redirectionMode = false)
    {
        $user = Auth::user();

        if ($user->admin_role_id == 1) {
            return $next($request);
        }

        $menuId = AdminMenu::where('slug', $menuName)->pluck('id')->first();

        if (!empty($menuId)) {
            $permissionDetails = AdminUserPermission::where('user_id', $user->id)
                ->where('menu_id', $menuId)
                ->where('action', $action)
                ->first();

            if (empty($permissionDetails)) {
                return redirect()->route('admin.profile');
                // if ($redirectionMode):
                //     abort(403);
                // else:
                //     return false;
                // endif;
            } else {
                return $next($request);
            }
        } else {
            return false;
        }
    }
}
