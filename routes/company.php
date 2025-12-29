<?php

use App\Http\Controllers\Company\ActivitiesController;
use App\Http\Controllers\Company\AssetsController;
use App\Http\Controllers\Company\CompaniesController;
use App\Http\Controllers\Company\CompanyProjectPermissionController;
use App\Http\Controllers\Company\CompanyRoleManagmentController;
use App\Http\Controllers\Company\CompanyUserController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\LabourController;
use App\Http\Controllers\Company\MaterialsController;
use App\Http\Controllers\Company\ProfileDesignationController;
use App\Http\Controllers\Company\ProjectController;
use App\Http\Controllers\Company\purchaseRequestController;
use App\Http\Controllers\Company\ReportController;
use App\Http\Controllers\Company\StoreWarehouseController;
use App\Http\Controllers\Company\SubProjectController;
use App\Http\Controllers\Company\SubscriptionCompanyController;
use App\Http\Controllers\Company\TeamsController;
use App\Http\Controllers\Company\UnitController;
use App\Http\Controllers\Company\VendorController;
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
    // **********************************************************************************************************
    Route::controller(CompanyUserController::class)->middleware(['subscription.check', 'check.trial'])->prefix('userManagment')->as('userManagment.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/user-permission/{uuid}', 'userPermission')->name('userPermission');
        Route::post('/add-user-permission', 'addUserPermission')->name('addUserPermission');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
    });
    // **********************************************************************************************************
    Route::controller(CompanyRoleManagmentController::class)->middleware(['subscription.check', 'check.trial'])->prefix('roleManagment')->as('roleManagment.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add/{id}', 'add')->name('add');
        Route::get('/add-permission/{id}', 'companyUserpermission')->name('companyUserpermission');
        Route::post('/add-permission', 'addPermission')->name('addPermission');
        Route::match(['get', 'post'], '/add-role', 'addRole')->name('role');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
    });
    // **********************************************************************************************************
    // Route::controller(CompaniesController::class)->middleware(['subscription.check', 'check.trial'])->prefix('companies')->as('companies.')->group(function () {
    Route::controller(CompaniesController::class)->middleware(['subscription.check', 'check.trial'])->prefix('companies')->as('companies.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });
    // **********************************************************************************************************
    Route::controller(CompanyProjectPermissionController::class)->middleware(['subscription.check', 'check.trial'])->prefix('projectPermission')->as('projectPermission.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('approval.add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('/project-filter/{uuid}', 'projectFilter')->name('project.filter');

        // Route::get('export', 'export')->name('export');

        // company.projectPermission.allocation.list

        // Route::get('/allocation-list', 'allocationList')->name('allocation.list');
        // Route::match(['get', 'post'], '/allocation-add', 'allocationAdd')->name('allocation.add');
    });

    // **********************************************************************************************************
    Route::controller(ProjectController::class)->middleware(['subscription.check', 'check.trial'])->prefix('project')->as('project.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });
    // **********************************************************************************************************
    Route::controller(SubProjectController::class)->middleware(['subscription.check', 'check.trial'])->prefix('subProject')->as('subProject.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });
    // **********************************************************************************************************
    Route::controller(StoreWarehouseController::class)->middleware(['subscription.check', 'check.trial'])->prefix('storeWarehouse')->as('storeWarehouse.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });
    // **********************************************************************************************************
    Route::controller(TeamsController::class)->middleware(['subscription.check', 'check.trial'])->prefix('teams')->as('teams.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });
    // **********************************************************************************************************
    Route::controller(ProfileDesignationController::class)->middleware(['subscription.check', 'check.trial'])->prefix('profileDesignation')->as('profileDesignation.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });
    // **********************************************************************************************************
    Route::controller(UnitController::class)->middleware(['subscription.check', 'check.trial'])->prefix('units')->as('units.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');

        Route::get('export', 'export')->name('export');
    });
    // **********************************************************************************************************
    Route::controller(LabourController::class)->middleware(['subscription.check', 'check.trial'])->prefix('labour')->as('labour.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

        Route::get('export', 'export')->name('export');
        Route::get('demo-export', 'DemoExportUnit')->name('demoExport');
        Route::post('import',  'import')->name('import');
    });
    // **********************************************************************************************************
    Route::controller(AssetsController::class)->middleware(['subscription.check', 'check.trial'])->prefix('assets')->as('assets.')->group(function () {
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
    // **********************************************************************************************************
    Route::controller(VendorController::class)->middleware(['subscription.check', 'check.trial'])->prefix('vendor')->as('vendor.')->group(function () {
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

    // **********************************************************************************************************
    Route::controller(ActivitiesController::class)->middleware(['subscription.check', 'check.trial'])->prefix('activities')->as('activities.')->group(function () {
        Route::get('/', 'index')->name('list');
        // Route::get('/preview/{uuid}', 'preview')->name('preview');
        Route::match(['get', 'post'], '/add', 'add')->name('add');
        Route::get('/edit/{uuid}', 'edit')->name('edit');
        Route::get('/subprojects/{id}', 'subprojects')->name('subprojects');
        Route::get('/storeprojects/{id}', 'storeprojects')->name('storeprojects');
        Route::get('/projectsstore/{id}', 'projectsstore')->name('projectsstore');
        Route::get('/activiteFieldHtml/{p}/{sp}', 'activiteFieldHtml')->name('activiteFieldHtml');
        Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

        Route::any('export', 'export')->name('export');
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
    // **********************************************************************************************************
    Route::controller(MaterialsController::class)->middleware(['subscription.check', 'check.trial'])->prefix('materials')->as('materials.')->group(function () {
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

    // **********************************************************************************************************
    Route::controller(ReportController::class)->middleware(['subscription.check', 'check.trial'])->prefix('report')->as('report.')->group(function () {
        Route::match(['get', 'post'], '/work-progress-details', 'workProgressDetails')->name('workProgressDetails');
        Route::match(['get', 'post'], '/dpr-details/{pid?}/{uid?}/{date?}', 'dprDetails')->name('dprDetails');
        // Route::match(['get', 'post'], '/dpr-details', 'dprDetails')->name('dprDetails');
        Route::match(['get', 'post'], '/resourcesUsageFromDPR-details', 'resourcesUsageFromDPRdetails')->name('resourcesUsageFromDPR');
        Route::match(['get', 'post'], '/matrialusedVsStoreIssue-details', 'matrialusedVsStoreIssuedetails')->name('matrialusedVsStoreIssue');
        Route::match(['get', 'post'], '/inventory-pr', 'inventorypr')->name('inventorypr');
        Route::match(['get', 'post'], '/rfq-details', 'rfq')->name('rfq');
        Route::match(['get', 'post'], '/grn-slip', 'grnSlip')->name('grnSlip');
        Route::match(['get', 'post'], '/grn-details', 'grnDetails')->name('grnDetails');
        Route::match(['get', 'post'], '/issue-slip', 'issueSlip')->name('issueSlip');
        Route::match(['get', 'post'], '/issue-outward-details', 'issueDetails')->name('issueDetails');
        Route::match(['get', 'post'], '/issueReturn-details', 'issueReturn')->name('issueReturn');
        Route::match(['get', 'post'], '/globalStockDetails-details', 'globalStockDetails')->name('globalStockDetails');
        Route::match(['get', 'post'], '/stockStatement-details', 'stockStatement')->name('stockStatement');
        Route::match(['get', 'post'], '/labour-strength', 'labourStrength')->name('labourStrength');
        Route::match(['get', 'post'], '/labour-contractor', 'labourContractor')->name('labourContractor');
        Route::match(['get', 'post'], '/work-contractor', 'workContractor')->name('workContractor');
        Route::post('/dprs-generate-pdf', 'dprGeneratePdf')->name('dpr-generate-pdf');
    });

    // **********************************************************************************************************
    Route::controller(SubscriptionCompanyController::class)->prefix('subscription')->as('subscription.')->group(function () {
        Route::match(['get', 'post'], '/subscription-list', 'index')->name('scriptionlist');
        Route::post('/subscription-payment', 'subscriptionadd')->name('subscriptionadd');
        Route::get('/subscription-add/{uuid}', 'add')->name('add');
        Route::get('/subscription-user-thank-you', 'thankU')->name('thankU');
    });

    Route::controller(purchaseRequestController::class)->middleware(['subscription.check', 'check.trial'])->prefix('pr')->as('pr.')->group(function () {
        Route::match(['get', 'post'], '/list', 'index')->name('list');
        Route::get('/details/{uuid}', 'details')->name('details');
        Route::post('/subscription-add', 'subscriptionadd')->name('subscriptionadd');
        Route::get('/subscription-user-thank-you', 'thankU')->name('thankU');

        Route::match(['get', 'post'], '/approval-list', 'approvalList')->name('approval.list');
        Route::match(['get', 'post'], '/approval-add', 'approvalAdd')->name('approval.add');
        Route::match(['get', 'put'], '/approval-setup/{id}', 'approvalsetup')->name('approval.setup');
        Route::match(['get', 'put'], '/approval-edit/{id}', 'approvaledit')->name('approval.edit');
    });
});
