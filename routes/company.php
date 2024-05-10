<?php

use App\Http\Controllers\Company\ActivitiesController;
use App\Http\Controllers\Company\AssetsController;
use App\Http\Controllers\Company\CompaniesController;
use App\Http\Controllers\Company\CompanyRoleManagmentController;
use App\Http\Controllers\Company\CompanyUserController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\LabourController;
use App\Http\Controllers\Company\MaterialsController;
use App\Http\Controllers\Company\OpeningStockController;
use App\Http\Controllers\Company\ProfileDesignationController;
use App\Http\Controllers\Company\ProjectController;
use App\Http\Controllers\Company\ReportController;
use App\Http\Controllers\Company\StoreWarehouseController;
use App\Http\Controllers\Company\SubProjectController;
use App\Http\Controllers\Company\TeamsController;
use App\Http\Controllers\Company\UnitController;
use App\Http\Controllers\Company\VendorController;
use App\Http\Controllers\Company\SubscriptionPackageOptionsController;
use Illuminate\Support\Facades\Route;

// Route::get('/company', function () {
//     return redirect()->route('company.login-show');
// })->middleware(['guest:web']);

Route::namespace('Company')->as('company.')->middleware(['auth:company', 'verified'])->group(function () {
    // Route::namespace('Company')->as('company.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('home');
        Route::get('/profile/{uuid}', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('updateProfile');
        // Route::match(['get','post'],'/change-password', 'changePassword')->name('change.password');
        Route::match(['get', 'post'], '/update-password', 'UpdatePassword')->name('passwordUpdate');
    });

    Route::controller(CompanyUserController::class)->prefix('userManagment')->as('userManagment.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/user-permission/{uuid}', 'userPermission')->name('userPermission');
        Route::post('/add-user-permission', 'addUserPermission')->name('addUserPermission');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
    });

    Route::controller(CompanyRoleManagmentController::class)->prefix('roleManagment')->as('roleManagment.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add/{id}', 'add')->name('add');
        Route::get('/add-permission/{id}', 'companyUserpermission')->name('companyUserpermission');
        Route::post('/add-permission/', 'addPermission')->name('addPermission');
        Route::match(['get', 'post'], '/add-role', 'addRole')->name('role');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
    });

    Route::controller(CompaniesController::class)->prefix('companies')->as('companies.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });

    Route::controller(ProjectController::class)->prefix('project')->as('project.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });

    Route::controller(SubProjectController::class)->prefix('subProject')->as('subProject.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });

    Route::controller(StoreWarehouseController::class)->prefix('storeWarehouse')->as('storeWarehouse.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });

    Route::controller(TeamsController::class)->prefix('teams')->as('teams.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });

    Route::controller(ProfileDesignationController::class)->prefix('profileDesignation')->as('profileDesignation.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });

    Route::controller(UnitController::class)->prefix('units')->as('units.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });

    Route::controller(LabourController::class)->prefix('labour')->as('labour.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

        Route::get('export', 'export')->name('export');
        Route::get('demo-export', 'DemoExportUnit')->name('demoExport');
        Route::post('import',  'import')->name('import');
    });

    Route::controller(AssetsController::class)->prefix('assets')->as('assets.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

        Route::get('export', 'export')->name('export');
        Route::get('demo-export', 'DemoExportUnit')->name('demoExport');
        Route::post('import',  'import')->name('import');

        Route::get('demo-opening-stock-export', 'exportOpeningStock')->name('exportOpeningStock');
        Route::post('opening-stock-import', 'importOpeningStock')->name('importOpeningStock');
        Route::match(['get', 'post'], '/addOpeningStock', 'addOpeningStock')->name('addOpeningStock');
        Route::get('/stock-edit/{uuid}', 'stockedit')->name('stockedit');
    });

    Route::controller(VendorController::class)->prefix('vendor')->as('vendor.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/preview/{uuid}', 'preview')->name('preview');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

        Route::get('export', 'export')->name('export');
        Route::get('demo-export', 'DemoExportUnit')->name('demoExport');
        Route::get('importExportView', 'importExportView');
        Route::post('import', 'import')->name('import');
    });

    Route::controller(ActivitiesController::class)->prefix('activities')->as('activities.')->group(function () {
        Route::get('/', 'index')->name('list');
        // Route::get('/preview/{uuid}', 'preview')->name('preview');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('/subprojects/{id}', 'subprojects')->name('subprojects');
        Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

        Route::get('export', 'export')->name('export');
        Route::get('demo-export', 'DemoExportUnit')->name('demoExport');
        Route::get('importExportView', 'importExportView');
        Route::post('import', 'import')->name('import');

        Route::get('activitiesAdd', 'activitiesAdd')->name('activitiesAdd');
        // Route::get('activitiesEdit/{uuid}', 'activitiesEdit')->name('activitiesEdit');
        Route::get('activitiesEdit', 'activitiesEdit')->name('activitiesEdit');
        Route::get('activitiesUpdate', 'activitiesUpdate')->name('activitiesUpdate');

        Route::get('non-import-data', 'nonImportData')->name('nonImportData');
        Route::get('non-import-data-export', 'NonImportDataExport')->name('NonImportDataExport');

        Route::get('copy-activites/', 'copyActivites')->name('copyActivites');
        Route::post('add-copy-activites/', 'addCopyActivites')->name('addCopyActivites');

        Route::post('find-copy-activites/', 'findId')->name('findId');
    });

    Route::controller(MaterialsController::class)->prefix('materials')->as('materials.')->group(function () {
        Route::get('/', 'index')->name('list');
        // Route::get('/preview/{uuid}', 'preview')->name('preview');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('/stock-history/{uuid}', 'stockhistory')->name('stockhistory');
        Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

        Route::get('export', 'export')->name('export');
        Route::get('demo-export', 'DemoExportUnit')->name('demoExport');
        Route::get('importExportView', 'importExportView');
        Route::post('import', 'import')->name('import');

        Route::match(['get', 'post'], '/addOpeningStock', 'addOpeningStock')->name('addOpeningStock');
        Route::get('/stock-edit/{uuid}', 'stockedit')->name('stockedit');
        Route::get('demo-opening-stock-export', 'exportOpeningStock')->name('exportOpeningStock');
        Route::post('opening-stock-import', 'importOpeningStock')->name('importOpeningStock');

        Route::get('/issue-stock-edit/{uuid}', 'issuestockedit')->name('issuestockedit');
    });

    // Route::controller(ReportController::class)->prefix('report')->as('report.')->group(function () {
    //     Route::match(['get', 'post'], '/company-report', 'companyReport')->name('companyReport');
    // });
});
