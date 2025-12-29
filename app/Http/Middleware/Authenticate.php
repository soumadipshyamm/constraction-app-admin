<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */ 
    protected function redirectTo(Request $request): ?string
    {
        $authenticateHeader = $request->header('authorization');
        // dd($authenticateHeader);
        if (!auth()->guard('company')->check()) {
            return redirect()->route('company.login'); // Redirect to admin login
        }else if (!Auth::guard('company-api')->check()) {
            if ($authenticateHeader) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return $request->expectsJson() ? null : route('admin.login');
        } 
        return null;
    }
}
