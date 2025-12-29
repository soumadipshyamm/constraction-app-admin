<?php

use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');

// Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

// Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');

// Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Route::get('/',[PageController::class, 'index'])->name('page');
// Route::get('/login',[PageController::class, 'login'])->name('company.login');
// Route::get('/registration',[PageController::class, 'registration'])->name('company.registration');
// Route::get('/',[PageController::class, 'index'])->name('page');

// Route::get('/error',

// Route::get('/send-email', function () {
    // Mail::to('soumadiphazra00@gmail.com')->send('email.forgetPassword', ['name' => 'John']);

    // $mail=Mail::raw('This is a raw text email sent from Laravel.', function ($message) {
    //     $message->to('soumadiphazra00@gmail.com', 'Recipient Name')->subject('Test Raw Text Email');
    // });
    // dd($mail);
    // Mail::raw('This is a raw text email sent from Laravel.', function ($message) {
    //     $message->to('soumadiphazra11@gmail.com', 'Recipient Name')->subject('Test Raw Text Email');
    // });
    // Mail::raw('This is a raw text email sent from Laravel.', function ($message) {
    //     $message->to('soumadip.hazra@maildrop.cc', 'Recipient Name')->subject('Test Raw Text Email');
    // });
    // Mail::raw('This is a raw text email sent from Laravel.', public function ($message) {
    //     $message->to('soumadip.hazra@maildrop.cc', 'Recipient Name')->subject('Test Raw Text Email');
    // });
    // Mail::raw('This is a raw text email sent from Laravel.', function ($message) {
    //     $message->to('tapas.sahoo@shyamfuture.com', 'Recipient Name')->subject('Test Raw Text Email');
    // });
//     return 'send email';
// });

// route::get('/export', [TestController::class, 'test']);
// Route::get('/examples', [TestController::class, 'exportCsv']);



Route::get('export', [TestController::class, 'export'])->name('export');
Route::get('demo-export', [TestController::class, 'DemoExportUnit'])->name('demoExport');
Route::get('importExportView', [TestController::class, 'importExportView']);
Route::post('import', [TestController::class, 'import'])->name('import');


Route::controller(CommonController::class)->group(function () {
    Route::match(['get','post'],'/user-delete-account', 'driverDeleteAccount')->name('driver.delete.account');
});
