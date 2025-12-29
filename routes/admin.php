<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleManagment;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\cms\HomePageController;
use App\Http\Controllers\Admin\UserManagmentController;
use App\Http\Controllers\Admin\cms\BannerPageController;
// use App\Http\Controllers\Admin\cms\HomePageController;
use App\Http\Controllers\Admin\CompanyManagmentController;
use App\Http\Controllers\Admin\cms\MenuManagmentController;
use App\Http\Controllers\Admin\cms\PageManagmentController;
use App\Http\Controllers\Admin\Setting\SettingsController;
use App\Http\Controllers\Admin\AdditionalFeaturesController;
use App\Http\Controllers\Admin\SubscriptionPackageController;
use App\Http\Controllers\Admin\TransactionController;

// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\RoleManagment;
// use App\Http\Controllers\Admin\UserManagmentController;

Route::namespace('Admin')
    ->as('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            // Auth::routes();
            // ->middleware('PermissionChecking')
            Route::get('/dashboard', 'index')
                ->name('home')
                ->middleware('admin.permissions:dashboard,view');
            Route::match(['get', 'post'], '/profile', 'profile')->name('profile');
            Route::match(['get', 'post'], '/update-password/', 'UpdatePassword')->name('passwordUpdate');

            // Route::get('/dashboard', 'index')->name('home');
            // Route::post('/edit/{uuid}', 'edit')->name('edit');
            // Route::match(['get','post'],'/change-password', 'changePassword')->name('change.password');
        });

        Route::controller(UserManagmentController::class)
            ->prefix('userManagment')
            ->as('userManagment.')
            ->group(function () {
                Route::get('/', 'index')
                    ->name('list')
                    ->middleware('admin.permissions:admin-user,view');
                Route::match(['get', 'post'], '/add', 'add')->name('add');
                Route::get('/user-permission/{uuid}', 'userPermission')->name('userPermission');
                Route::post('/add-user-permission/', 'addUserPermission')->name('addUserPermission');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
            });
        Route::controller(RoleManagment::class)
            ->prefix('roleManagment')
            ->as('roleManagment.')
            ->group(function () {
                Route::get('/', 'index')
                    ->name('list')
                    ->middleware('admin.permissions:admin-management-site-engineering,view');
                Route::get('/add/{id}', 'add')->name('add');
                Route::post('/add-permission/', 'addPermission')->name('addPermission');
                Route::match(['get', 'post'], '/add-role', 'addRole')->name('role');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
            });

        Route::controller(CompanyManagmentController::class)
            ->prefix('companyManagment')
            ->as('companyManagment.')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::match(['get', 'post'], '/add', 'add')->name('add');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
                Route::get('/preview/{uuid}', 'preview')->name('preview');
                Route::match(['get', 'post'], '/update-password', 'UpdatePassword')->name('passwordUpdate');
            });

        Route::controller(PageManagmentController::class)
            ->prefix('pageManagment')
            ->as('pageManagment.')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::match(['get', 'post'], '/add', 'add')->name('add');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
                Route::post('uploadFile', 'uploadFile')->name('uploadFile');
            });

        Route::controller(HomePageController::class)
            ->prefix('home-page')
            ->as('homePage.')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::match(['get', 'post'], '/add', 'add')->name('add');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
                Route::post('uploadFile', 'uploadFile')->name('uploadFile');
            });
        Route::controller(MenuManagmentController::class)
            ->prefix('menu-managment')
            ->as('menuManagment.')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::match(['get', 'post'], '/add', 'add')->name('add');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
                Route::post('uploadFile', 'uploadFile')->name('uploadFile');
            });
        Route::controller(BannerPageController::class)
            ->prefix('banner-managment')
            ->as('bannerManagment.')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::match(['get', 'post'], '/add', 'add')->name('add');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
                Route::post('uploadFile', 'uploadFile')->name('uploadFile');
            });

        Route::controller(SubscriptionPackageController::class)->prefix('subscription-managment')->as('subscription.')->group(function () {
            Route::get('/', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'add')->name('add');
            Route::post('/add-subscription-option', 'addSubscriptionOption')->name('addSubscriptionOption');
            Route::get('/edit-subscription-option/{uuid}', 'editSubscriptionOption')->name('editSubscriptionOption');
            Route::get('/edit/{uuid}', 'edit')->name('edit');
        });

        Route::controller(AdditionalFeaturesController::class)->prefix('additional-features')->as('additionalFeatures.')->group(function () {
            Route::get('/', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'add')->name('add');
            Route::get('/edit', 'edit')->name('edit');
        });

        // });
        // Route::controller(SubscriptionPackageController::class)->prefix('subscription-managment')->as('subscription.')->group(function () {
        //     Route::get('/', 'index')->name('list');
        //     Route::match(['get', 'post'], '/add', 'add')->name('add');
        //     Route::post('/add-subscription-option', 'addSubscriptionOption')->name('addSubscriptionOption');
        //     Route::get('/edit-subscription-option/{uuid}', 'editSubscriptionOption')->name('editSubscriptionOption');
        //     Route::get('/edit/{uuid}', 'edit')->name('edit');
        // });

        // Route::controller(AdditionalFeaturesController::class)->prefix('additional-features')->as('additionalFeatures.')->group(function () {
        //     Route::get('/', 'index')->name('list');
        //     Route::match(['get', 'post'], '/add', 'add')->name('add');
        //     Route::get('/edit', 'edit')->name('edit');
        // });

        Route::controller(TransactionController::class)->prefix('subscriptiontransactions')->as('transactions.')->group(function () {
            Route::get('/', 'index')->name('list');
        });

        Route::controller(SettingsController::class)->prefix('setting')->as('setting.')->group(function () {
            Route::match(['get', 'post'], '/contact-details', 'contactDetails')->name('contactDetails');
            Route::get('/contact-report', 'contactReport')->name('contactReport');
            //     Route::match(['get', 'post'], '/add', 'add')->name('add');
            //     Route::get('/edit', 'edit')->name('edit');
        });
    });
