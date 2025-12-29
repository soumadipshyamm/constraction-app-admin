<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = 'admin/dashboard';
    protected $namespace = 'App\Http\Controllers';
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
        $this->mapAuthRoutes();
        $this->mapAdminRoutes();
        $this->mapAjaxRoutes();
        $this->mapCompanyRoutes();
        $this->mapSubscriptionRoutes();
        $this->mapFrontendRoutes();
        $this->mapTestRoutes();
    }
    protected function mapAuthRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/auth.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));
    }
    protected function mapCompanyRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('company')
            ->group(base_path('routes/company.php'));
    }
    protected function mapSubscriptionRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('subscription')
            ->group(base_path('routes/subscription.php'));
    }
    protected function mapFrontendRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend.php'));
    }
    protected function mapTestRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/test.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Ajax')
            ->prefix('ajax')
            ->group(base_path('routes/ajax.php'));
    }
}
