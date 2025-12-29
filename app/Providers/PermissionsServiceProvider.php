<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Models\Company\Company_permission;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // try {
        //     Company_permission::get()->map(function ($permission) {
        //         Gate::define($permission->slug, function ($user) use ($permission) {
        //             return $user->hasPermissionTo($permission);
        //         });
        //     });
        // } catch (\Exception $e) {
        //     report($e);
        //     // return false;
        // }

        // //Blade directives
        // Blade::directive('Company_role', function ($role) {
        //      return "if(auth()->guard('company')->check() && auth()->guard('company')->hasRole({$role})) :"; //return this if statement inside php tag
        // });

        // Blade::directive('endrole', function ($role) {
        //      return "endif;"; //return this endif statement inside php tag
        // });


    }
}
