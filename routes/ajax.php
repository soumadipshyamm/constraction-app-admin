<?php

use App\Http\Controllers\Ajax\AjaxController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ajax routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "ajax" middleware group. Make something great!
|
 */

Route::controller(AjaxController::class)->prefix('ajax')->as('ajax.')->group(function () {
    Route::get('get-states/', 'getStates')->name('getStates');
    Route::get('get-cities/', 'getCities')->name('getCities');
});

Route::as('ajax.')->middleware(['auth', 'verified'])->group(function () {
    Route::controller(AjaxController::class)->group(function () {
        Route::group(['as' => 'get.'], function () {
            Route::get('/getBoards', 'getBoards')->name('boards');
        });
        Route::group(['as' => 'update.'], function () {
            Route::match(['put', 'post'], '/updateStatus', 'setStatus')->name('status');
            Route::match(['put', 'post'], '/update/settings', 'updateSettings')->name('settings');
        });
        Route::group(['as' => 'delete.'], function () {
            Route::delete('/deleteData', 'deleteData')->name('data');
        });
    });
});

Route::as('ajax.')->middleware(['auth:company', 'verified'])->group(function () {
    Route::controller(AjaxController::class)->group(function () {
        // Route::group(['as' => 'get.'], function () {
        Route::get('/subprojects', 'subprojects')->name('subprojects');
        Route::get('/getMaterials/{id}', 'getMaterials')->name('getMaterials');
        // });
        Route::group(['as' => 'update.'], function () {
            Route::match(['put', 'post'], '/companyUpdateStatus', 'setStatus')->name('status');
            Route::match(['put', 'post'], '/update/settings', 'updateSettings')->name('settings');
        });
        Route::group(['as' => 'delete.'], function () {
            Route::delete('/companydeleteData', 'deleteData')->name('data');
        });
    });
});
