<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Admin\Auth\LoginController;

Route::controller(LoginController::class)->prefix('admin')->as('admin.')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginPost')->name('loginPost');
    Route::get('/logout', 'logout')->name('logout');
    // Route::match (['get', 'post'], '/forgotPassword', 'forgotPassword')->name('forgotPassword');
    // Route::match (['get', 'post'], '/registration', 'registration')->name('registration');
    Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
    Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post');
    Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
});

Route::controller(PageController::class)->prefix('company')->as('company.')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginPost')->name('loginPost');
    Route::get('/logout', 'logout')->name('logout');

    Route::match (['get', 'post'], '/registration', 'registration')->name('registration');
    Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
    Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post');
    Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');

});

// Route::get('/company', function () {
//     return redirect()->route('company.login');
// })->middleware(['guest:web']);
// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect(route('user.email.verification.success'));
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Route::namespace('Auth')->controller(VerificationController::class)->middleware(['auth','verified'])->group(function () {
//     Route::get('/email-verification-success','userEmailVerificationSuccess')->name('user.email.verification.success');
// });
