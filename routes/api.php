<?php

use App\Http\Controllers\API\ActivitiesController;
use App\Http\Controllers\API\ActivityHistoryController;
use App\Http\Controllers\API\AssetsController;
use App\Http\Controllers\API\AssetsHistoryController;
use App\Http\Controllers\API\DprController;
use App\Http\Controllers\API\HinderanceController;
use App\Http\Controllers\API\SafetyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\API\LaboursController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\CompaniesController;
use App\Http\Controllers\API\SubProjectController;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\dashboard\DashboardController;
use App\Http\Controllers\API\inventory\GoodsController;
use App\Http\Controllers\API\inventory\InventoryController;
use App\Http\Controllers\API\inventory\InvInwardController;
use App\Http\Controllers\API\inventory\InvIssueController;
use App\Http\Controllers\API\inventory\InvIssueGoodController;
use App\Http\Controllers\API\inventory\InvIssuesDetailsController;
use App\Http\Controllers\API\inventory\InvReturnController;
use App\Http\Controllers\API\inventory\InvReturnsDetailsController;
use App\Http\Controllers\API\LabourHistoryController;
use App\Http\Controllers\API\MaterialsController;
use App\Http\Controllers\API\MaterialsHistoryController;
use App\Http\Controllers\API\inventory\QuoteController;
use App\Http\Controllers\API\inventory\InwardGoodsController;
use App\Http\Controllers\API\inventory\InwardGoodsDetailsController;
use App\Http\Controllers\API\inventory\MaterialRequestController;
use App\Http\Controllers\API\inventory\MaterialRequestDetailsController;
use App\Http\Controllers\API\inventory\QuotesDetailsController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\StoreWarehouseController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\TeamsController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserChatController;
use App\Http\Controllers\API\VendorsController;
use App\Http\Controllers\InvReturnGoodController;
use App\Http\Controllers\NotifactionController;
use App\Http\Controllers\TestController;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use App\Models\Notifaction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/sign-up', [AuthenticationController::class, 'signUp']);
Route::post('/otp_verification', [AuthenticationController::class, 'otpVerification']);
Route::post('/resend-otp-verification', [AuthenticationController::class, 'resendOtp']);
Route::post('/forgot-password-update', [AuthenticationController::class, 'forgotPasswordUpdate']);
Route::post('/forgot-email', [AuthenticationController::class, 'getEmailforgotePassword']);
Route::post('/forgot-email-otp-verification', [AuthenticationController::class, 'getOtpverification']);
Route::post('/sign-in', [AuthenticationController::class, 'login']);

Route::middleware(['auth:company-api', "scopes:company"])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::any('dashboard-overview', 'dashboardOverview');
        Route::post('/dashboard-overview-search', 'dashboardOverviewSearch');
        Route::post('get-work-overview/', 'workstatus')->name('company.dashboard.workoverview');
        Route::post('get-work-process/', 'workprocess')->name('company.dashboard.workprocess');
        Route::post('get-inventory-stocks/', 'getstocksinventory')->name('company.dashboard.stocks');
        Route::post('get-inward-stocks/', 'getInwardStocks')->name('company.inward.stocks');
    });
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('/profile-list', 'profileList');
        Route::any('/profile-update', 'profileUpdate');
        Route::post('/password-update', 'passwordUpdate');
        Route::post('/logout', 'logout');
    });

    Route::controller(CompaniesController::class)->group(function () {
        Route::get('companies-list', 'companiesList');
        Route::post('companies-add', 'companiesAdd');
        Route::post('/companies-search', 'companiesSearch');
        Route::get('/companies-edit/{uuid}', 'edit')->name('edit');
        Route::delete('/companies-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(ProjectController::class)->group(function () {
        Route::get('project-list', 'projectlist');
        Route::post('/project-add', 'projectAdd');
        Route::post('/project-search', 'projectSearch');
        Route::get('/project-edit/{uuid}', 'edit')->name('edit');
        Route::post('/project-subproject', 'projectSubproject')->name('projectSubproject');

        // ******************************* DPR ***************************
        Route::post('/fetch-project-subproject', 'fetchprojectSubproject')->name('fetchprojectSubproject');
        Route::post('/project-wise-subproject-search', 'projectWiseSubprojectSearch')->name('projectWiseSubprojectSearch');
        Route::delete('/project-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(SubProjectController::class)->group(function () {
        Route::get('sub-project-list', 'subProjectlist');
        Route::post('sub-project-add', 'subProjectAdd');
        Route::post('/sub-project-search', 'subProjectSearch');
        Route::get('/sub-project-edit/{uuid}', 'edit')->name('edit');
        Route::delete('/sub-project-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(StoreWarehouseController::class)->group(function () {
        Route::get('store-list', 'list');
        Route::post('project-wise-store-list', 'projectWiseStoreList');
        Route::post('store-add', 'add');
        Route::post('store-search', 'search');
        Route::get('store-edit/{uuid}', 'edit')->name('edit');
        Route::delete('store-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(LaboursController::class)->group(function () {
        Route::get('labour-list', 'listLabour');
        Route::post('labour-add', 'addLabour');
        Route::post('/labour-search', 'labourSearch');
        Route::get('labour-edit/{uuid}', 'edit')->name('edit');
        Route::delete('labour-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(UnitController::class)->group(function () {
        Route::get('unit-list', 'unitList');
        Route::post('unit-add', 'unitAdd');
        Route::post('/unit-search', 'unitSearch');
        Route::get('unit-edit/{uuid}', 'edit')->name('edit');
        Route::delete('unit-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(AssetsController::class)->group(function () {
        Route::get('assets-list', 'assetsList');
        Route::post('assets-add', 'assetsAdd');
        Route::post('/assets-search', 'assetsSearch');
        Route::get('assets-edit/{uuid}', 'edit')->name('edit');
        Route::delete('assets-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(VendorsController::class)->group(function () {
        Route::get('vendor-list', 'vendorList');
        Route::post('supplier-contractor-list', 'supplierContractorList');
        Route::post('vendor-add', 'vendorAdd');
        Route::post('/vendor-search', 'vendorSearch');
        Route::get('/vendor-edit/{uuid}', 'edit')->name('edit');
        Route::delete('/vendor-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(ActivitiesController::class)->group(function () {
        // Route::get('activities-list', 'activitiesList');
        // Route::post('/project-subproject-wise-list', 'projectSubprojectWiseList')->name('projectSubprojectWiseList');
        // Route::post('activities-list', 'activitiesList');
        Route::match(['get', 'post'], 'activities-list', 'activitiesList');
        Route::post('activities-add', 'activitiesAdd');
        Route::post('activities-search', 'activitiesSearch');
        Route::get('/activities-edit/{uuid}', 'edit')->name('edit');
        // Route::get('/activities-heading', 'headingActivitiesprantChild')->name('headingActivitiesprantChild');
        Route::delete('/activities-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(MaterialsController::class)->group(function () {
        Route::get('materials-list', 'materialsList');
        Route::post('materials-add', 'materialsAdd');
        Route::post('materials-search', 'materialsSearch');
        Route::get('/materials-edit/{uuid}', 'edit')->name('edit');
        Route::delete('/materials-delete/{uuid}', 'delete')->name('delete');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('role-list', 'roleList');
    });

    Route::controller(TeamsController::class)->group(function () {
        Route::get('teams-list', 'teamsList');
        Route::post('teams-add', 'teamsAdd');
        Route::post('teams-search', 'search');
        Route::get('/teams-edit/{uuid}', 'edit')->name('edit');
        Route::post('/teams-details', 'details')->name('details');
        Route::delete('/teams-delete/{uuid}', 'delete')->name('delete');
        Route::post('/teams-password-update/{uuid}', 'teamsPasswordUpdate');
        Route::get('/teams-chat', 'teamsChat'); //data fetch firebase
    });

    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('subscription-list', 'subscriptionList');
        // Route::get('subscription-list', 'subscriptionList');
        // Route::get('subscription-list', 'subscriptionList');
    });

    // **********************DPR*******************************************************
    Route::controller(DprController::class)->group(function () {
        Route::get('dpr-list', 'index');
        Route::post('dpr-add', 'add');
        Route::get('dpr-edit/{id}', 'edit');
        Route::delete('dpr-delete/{id}', 'delete');

        Route::get('dpr-check', 'dprCheck');
        Route::post('fetch-dpr-history-edit', 'dprHistoryEdit');
        Route::post('dpr-history-Update', 'dprHistoryUpdate');

        Route::post('/generate-pdf', 'generatePDF');
        Route::post('/dpr-bulk-add', 'bulkDprAdd');
    });

    Route::controller(ActivityHistoryController::class)->group(function () {
        Route::post('activities-history-list', 'index');
        // Route::get('activities-history-list/{id}', 'index');
        Route::post('activities-history-add', 'add');
        Route::post('activities-history-edit/', 'edit');
        // Route::get('activities-history-edit/{id}', 'edit');
        Route::post('test-api', 'testtt');

        Route::post('activities-project-search', 'activitiesProjectSearch');
        // Route::post('project-subproject-search', 'projectWiseSubProject');
    });

    Route::controller(LabourHistoryController::class)->group(function () {
        Route::get('labour-history-list/{id}', 'index');
        Route::post('labour-history-add', 'add');
        Route::post('labour-history-edit/', 'edit');
    });

    Route::controller(AssetsHistoryController::class)->group(function () {
        Route::post('assets-history-list', 'index');
        Route::post('assets-history-add', 'add');
        Route::post('assets-history-edit', 'edit');
    });

    Route::controller(MaterialsHistoryController::class)->group(function () {
        Route::get('materials-history-list/', 'index');
        Route::post('materials-history-add', 'add');
        // Route::get('materials-history-edit', 'edit');
        Route::post('materials-history-edit', 'edit');

        Route::post('materials-opening-list', 'materialsOpening');
    });

    Route::controller(SafetyController::class)->group(function () {
        Route::match(['get', 'post'], 'safety-list', 'index');
        Route::post('safety-add', 'add');
        Route::get('safety-edit/{uuid}', 'edit');
        Route::delete('safety-delete/{id}', 'delete');
    });

    Route::controller(HinderanceController::class)->group(function () {
        Route::match(['get', 'post'], 'hinderance-list', 'index');
        Route::post('hinderance-add', 'add');
        Route::get('hinderance-edit/{uuid}', 'edit');
        Route::delete('hinderance-delete/{id}', 'delete');
    });
    // ***********************inventory**************************************
    Route::prefix('inventory')->as('inventory.')->group(function () {

        // Materials Request Creation
        Route::controller(MaterialRequestController::class)->group(function () {
            // Route::post('project-to-subproject-list', 'projectToSubprojectList')->name('projectToSubprojectList');
            // Route::get('materials-request-list', 'index');
            Route::match(['get', 'post'], 'materials-request-list', 'index');
            // Route::post('materials-request-list', 'index');
            // Route::match(['get', 'post'], 'materials-request-list', 'index');
            Route::post('materials-request-add', 'add');
            Route::post('materials-request-edit', 'edit')->name('edit');

            // ************************Notifaction PR Approval**************************************************
            Route::match(['get', 'post'], 'pending-approval-list', 'pendingApprovalList')->name('pendingApprovalList');
            Route::match(['get', 'post'], 'pending-approval-update-status', 'pendingApprovalUpdate')->name('pendingApprovalUpdate');

            // ************************Quote**************************************************
            Route::match(['get', 'post'], 'quotes-materials-request-list', 'materialsRequestListforQuote')->name('materialsRequestListforQuote');
            Route::post('materials-request-no-wise-materials-list', 'materialsRequestNoWiseMaterialsShow')->name('materialsRequestNoWiseMaterialsShow');
            // Route::post('materials-request-no-wise-materials-edit', 'materialsRequestNoWiseMaterialsEdit')->name('materialsRequestNoWiseMaterialsEdit');
        });

        // Materials Request Detail
        Route::controller(MaterialRequestDetailsController::class)->group(function () {
            Route::post('materials-request-details-list', 'index');
            Route::post('materials-request-details-add', 'add');
            Route::post('materials-request-details-edit', 'edit')->name('edit');
            // Route::post('/generate-pdf', 'generatePDF');
        });

        // **************************************************************************
        // Quote creation request
        Route::controller(QuoteController::class)->group(function () {
            Route::get('quote-list', 'index');
            Route::post('quote-add', 'add');
            Route::post('quote-edit', 'edit')->name('edit');
            Route::post('quote-details-test-img', 'quotedetailstestimg')->name('quotedetailstestimg');
        });

        // Quote Details
        Route::controller(QuotesDetailsController::class)->group(function () {
            Route::get('quote-details-list', 'index');
            Route::post('quote-details-add', 'add');
            Route::post('quote-details-edit', 'edit')->name('edit');
            Route::post('material-request-send-to-vendor', 'materialrequestSendToVendor')->name('materialrequestSendToVendor');
        });

        // ***************************************************************************
        // Goods
        Route::controller(GoodsController::class)->group(function () {
            Route::get('goods-list', 'index');
            Route::post('goods-add', 'add');
            Route::get('goods-edit/{id}', 'edit')->name('edit');
        });

        // Inward goods Create
        Route::controller(InvInwardController::class)->group(function () {
            Route::post('project-to-store-list', 'projectToStoreList')->name('projectToStoreList');
            Route::get('inward-list', 'index');
            Route::post('inward-add', 'add');
            Route::get('inward-edit/{id}', 'edit')->name('edit');
        });

        // Inward goods Details
        Route::controller(InwardGoodsController::class)->group(function () {
            Route::get('inward-goods-list', 'index');
            Route::get('inward-goods-entry-type-list', 'entryType');
            Route::post('inward-goods-entry-type-id', 'invFetchentryType');
            Route::post('inward-goods-add', 'add');
            Route::post('inward-goods-search', 'inwardGoodSearch');
            Route::post('inward-goods-edit', 'edit')->name('edit');
        });

        // Inward Issue goods details
        Route::controller(InwardGoodsDetailsController::class)->group(function () {
            Route::get('inward-goods-details-list', 'index');
            Route::post('inward-goods-details-add', 'add');
            // Route::get('inward-goods-details-search', 'subscriptionSearch');
            Route::post('inward-goods-details-edit', 'edit')->name('edit');
        });

        // ****************************************************************************
        // issue create
        Route::controller(InvIssueController::class)->group(function () {
            Route::post('issue-add', 'add');
            Route::post('issue-material-list', 'materialsList');
            Route::get('issue-type-list', 'issueTypeList');
            Route::post('issue-type-tag-list', 'issueTypeTagList');
            Route::get('issue-list', 'list');
        });

        // issue good
        Route::controller(InvIssueGoodController::class)->group(function () {
            Route::post('issue-goods-add', 'add');
            Route::post('issue-goods-list', 'list');
            Route::post('issue-goods-edit', 'edit');
        });

        // issue good  details
        Route::controller(InvIssuesDetailsController::class)->group(function () {
            Route::get('issue-goods-details-list', 'index');
            Route::post('issue-goods-details-add', 'add');
            Route::get('issue-goods-details-edit/{id}', 'edit')->name('edit');
        });

        // ********************************************************************************************
        //Return create
        Route::controller(InvReturnController::class)->group(function () {
            Route::get('return-list', 'index');
            Route::post('return-add', 'add');
            Route::post('return-edit', 'edit')->name('edit');
            // Route::get('return-edit/{id}', 'edit')->name('edit');
        });
        // Return goods
        Route::controller(InvReturnGoodController::class)->group(function () {
            // Route::get('return-list', 'index');
            Route::post('return-goods-add', 'add');
            // Route::get('return-edit/{id}', 'edit')->name('edit');
        });
        // Return gooods details
        Route::controller(InvReturnsDetailsController::class)->group(function () {
            // Route::get('return-list', 'index');
            Route::post('return-goods-details-add', 'add');
            // Route::get('return-edit/{id}', 'edit')->name('edit');
        });
        // ********************************************************************************************
        // inventory
        Route::controller(InventoryController::class)->group(function () {
            Route::get('inventory-list', 'index');
            Route::post('inventory-add', 'add');
            Route::get('inventory-edit/{id}', 'edit')->name('edit');

            Route::post('/generate-pdf', 'generatePDF');

            Route::post('/inward-list-materials', 'listMaterials');
            Route::post('/inward-list-machine', 'listMachine');
            Route::post('/issue-list-materials', 'issuelistMaterials');
            Route::post('/issue-list-machine', 'issuelistMachine');
        });
        // ********************************************************************************************
        Route::controller(ReportController::class)->group(function () {
            Route::post('inventory-report', 'reportGenerate');
            // Route::post('dashboard-work-status-report', 'dashboardWorkStatusReport');
        });
    });

    // *************************Notifaction********************************************
    Route::controller(NotifactionController::class)->group(function () {
        Route::post('/test-notifaction', 'testNotifaction'); // for firebase testing
        Route::get('/fetch-notifaction', 'fetchNotifaction');
        Route::post('/update-notifaction', 'viewNotifactionUpdate');
        Route::post('/view-all-notifaction', 'viewAllNotifaction');
    });
    // ******************************************************************************************
    // createChat
    Route::controller(UserChatController::class)->group(function () {
        Route::post('/fcm-update', 'fcmUpdate');
        Route::any('/user-createChat', 'createChat'); // for firebase testing
        Route::any('/user-chat-list', 'userList'); // for firebase testing
        Route::any('/send-push-notification', 'sendPushNotification'); // for firebase testing
    });
});

Route::controller(CommonController::class)->group(function () {
    Route::get('get-country', 'getCountry')->name('getCountry');
    Route::post('get-states', 'getStates')->name('getStates');
    Route::post('get-cities', 'getCities')->name('getCities');
    Route::get('privacy_policy', 'privacyPolicy')->name('privacyPolicy');
});

// Route::controller(TestController::class)->group(function () {
//     Route::get('test-sms', 'testSms')->name('testSms');
// });
