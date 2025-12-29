<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {

    // Route::get('/', 'test')->name('test');
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/page/{name}', 'page')->name('page');
    // Route::get('/page/{name}/{uuid}', 'page')->name('page');
    Route::match(['get', 'post'], '/contact-us', 'contactUs')->name('contactUs');
    Route::get('/product', 'product')->name('product');
    // Route::get('/page', 'page')->name('site_page');

    Route::get('/list-subscription', 'subscription')->name('user.subscription');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacyPolicy');
});
