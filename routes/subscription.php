<?php

use App\Http\Controllers\Subscription\SubscriptionPackageOptionsController;
use Illuminate\Support\Facades\Route;

// Route::get('/company', function () {
//     return redirect()->route('company.login-show');
// })->middleware(['guest:web']);
// Route::namespace('Subscription')->as('subscription.')->middleware(['auth:company', 'verified'])->group(function () {

Route::namespace('Subscription')->as('subscription.')->group(function () {
    Route::controller(SubscriptionPackageOptionsController::class)->group(function () {
        Route::get('/', 'index')->name('list');
    });
});
