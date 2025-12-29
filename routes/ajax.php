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

// Route::controller(AjaxController::class)->prefix('ajax')->as('ajax.')->group(function () {
Route::controller(AjaxController::class)->group(function () {
    Route::get('get-states/', 'getStates')->name('getStates');
    Route::get('get-cities/', 'getCities')->name('getCities');
    // Route::post('subscription-add/', 'subscriptionAdd')->name('company.subscription.add');
    // *****************************************

    // Dashboard overview
    Route::post('get-work-overview-monthly-rogress/', 'monthlyProgress')->name('company.dashboard.monthlyProgress');
    Route::post('get-work-overview/', 'workstatus')->name('company.dashboard.workoverview');

    // Dashboard work-process
    Route::post('get-work-process/', 'workprocess')->name('company.dashboard.workprocess');
    Route::post('get-work-process-activities/', 'getworkProcessActivities')->name('company.dashboard.workprocess.activities');

    // Dashboard stocks
    Route::post('get-inventory-stocks/', 'getstocksinventory')->name('company.dashboard.stocks');
    Route::post('get-inventory-stocks-details/', 'getstocksinventorydetails')->name('company.dashboard.stocks.details');

    Route::post('get-form-work-progress-details/', 'workProgressDetails')->name('company.report.workProgressDetails');
    Route::post('get-form-work-progress-dpr-details/', 'workProgressDprDetails')->name('company.report.workProgressDprDetails');
    Route::post('get-resources-usage-from-dpr-date/', 'resourcesUsageFromDprDate')->name('company.report.resourcesUsageFromDprDate');
    Route::post('get-resources-usage-from-dpr-days/', 'resourcesUsageFromDprDays')->name('company.report.resourcesUsageFromDprDays');
    Route::post('get-matrial-used-vs-store-issue/', 'matrialusedVsStoreIssue')->name('company.report.matrialusedVsStoreIssue');
    // ***************************************************************************************************************

    //Inventory
    Route::post('get-inventory-pr/', 'inventorypr')->name('company.report.inventorypr');
    Route::post('get-inventory-rfq/', 'inventoryrfq')->name('company.report.inventory.rfq');
    Route::post('get-inventory-project-stock/', 'inventoryProjectStock')->name('company.report.inventory.project.stock');
    Route::post('get-inventory-global-project-stock/', 'inventoryGlobalProjectStock')->name('company.report.inventory.global.project.stock');
    Route::post('get-inventory-issue-return/', 'inventoryIssueReturn')->name('company.report.inventory.issue.return');
    Route::post('get-inventory-issue-outward-details/', 'inventoryIssueReturnDetails')->name('company.report.inventory.issue.outward.details');
    Route::post('get-inventory-issue-slips/', 'inventoryIssueSlip')->name('company.report.inventory.issue.slips');
    Route::post('get-inventory-grn-details/', 'inventoryGrnDetails')->name('company.report.inventory.grn.details');
    Route::post('get-inventory-grn-slips/', 'inventoryGrnSlips')->name('company.report.inventory.grn.slips');
    // Route::post('get-inventory-grn-slips/', 'inventoryGrnSlips')->name('company.report.inventory.grn.slips');
    // Route::post('get-work-process/', 'activitesWorkDetails')->name('company.dashboard.activitesWorkDetails');

    Route::post('get-report-labour-strength/', 'labourStrengthreport')->name('company.report.labourStrength');
    Route::post('/getprdetails', 'getPrDetails')->name('getPrDetails');    // Route::post('get-pr-details', 'getPrDetails')->name('getPrDetails');

    // PDF
    Route::post('get-form-work-progress-dpr-details-pdf/', 'workProgressDprDetailsPdf')->name('company.report.workProgressDprDetailsPdf');
    Route::get('/download-pdf/{filename}', 'downloadPdf')->name('download.pdf');


    //material opening stock find
    Route::post('get-material-opening-stock/', 'materialOpeningStock')->name('company.report.materialOpeningStock');
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
            // Route::delete('/deleteData-id', 'deleteDataId')->name('data.delete.id');
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
            Route::match(['put', 'post'], '/company-custome-update-status', 'companyCustomeUpdateStatus')->name('companyCustomeUpdateStatus');
            Route::match(['put', 'post'], '/update/settings', 'updateSettings')->name('settings');
        });
        Route::group(['as' => 'delete.'], function () {
            Route::delete('/companydeleteData', 'deleteData')->name('data');
        });
    });
});
