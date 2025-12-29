<?php

use App\Http\Resources\API\Activities\DprActivitesResources;
use App\Http\Resources\API\Company\CompanyResource;
use App\Http\Resources\API\CompanyUser\UserResource;
use App\Http\Resources\API\DPR\DprLabourResources;
use App\Http\Resources\API\DPR\DprMaterialsResources;
use App\Http\Resources\API\Inventory\inventor\InvProjectListResources;
use App\Http\Resources\Api\Notifaction\NotifactionResource;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Store\StoreResources;
use App\Http\Resources\AssetsResource;
use App\Http\Resources\DPR\DprAssetsResources;
use App\Http\Resources\VendorResource;
use App\Mail\TestMail;
use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use Illuminate\Support\Str;
use App\Models\Company\Unit;
use App\Models\Company\Teams;
use Intervention\Image\Image;
use Illuminate\Support\Carbon;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\AdminNotifaction;
use App\Models\Admin\AdminRole;
use App\Models\Company\Project;
use App\Models\Company\Companies;
use App\Models\Company\Materials;
use App\Models\Admin\Cms\HomePage;
use App\Models\Company\Activities;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\PageManagment;
use App\Models\Company\CompanyUser;
use App\Models\Company\Company_role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\StoreWarehouse;
use App\Models\Admin\Cms\MenuManagment;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\AdminUserPermission;
use App\Models\Company\Company_permission;
use App\Models\Company\profileDesignation;
use App\Models\Admin\Settings\ContactDetails;
use App\Models\API\Dpr;
use App\Models\API\Safety;
use App\Models\Company\ActivityHistory;
use App\Models\Company\Assets;
use App\Models\Company\AssetsHistory;
use App\Models\Company\Company_role_permission;
use App\Models\Company\Company_user_permission;
use App\Models\Company\InwardGoods;
use App\Models\Company\InwardGoodsDetails;
use App\Models\Company\Labour;
use App\Models\Company\LabourHistory;
use App\Models\Company\MaterialsHistory;
use App\Models\Company\PrApprovalMember;
use App\Models\Company\PrMemberManagment;
use App\Models\Company\Vendor;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\InvInward;
use App\Models\InvInwardEntryType;
use App\Models\InvIssue;
use App\Models\InvIssueGood;
use App\Models\InvIssueList;
use App\Models\InvIssuesDetails;
use App\Models\InvReturn;
use App\Models\InvReturnGood;
use App\Models\InvReturnsDetails;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use App\Models\Notifaction;
use App\Models\Subscription\SubscriptionOptions;
use App\Models\Subscription\SubscriptionPackage;
use App\Models\Subscription\SubscriptionPackageOptions;
use App\Models\SubscriptionCompany;
use App\Models\SubscriptionLogs;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler; // For daily rotation
use Illuminate\Log\Logger as IlluminateLogger;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use function PHPUnit\Framework\isEmpty;

if (!function_exists('isSluggable')) {
    function isSluggable($value)
    {
        return Str::slug($value);
    }
}
// ***********************************************************************************************************
if (!function_exists('isMobileDevice')) {
    function isMobileDevice()
    {
        return preg_match(
            "/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                            |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",
            $_SERVER["HTTP_USER_AGENT"]
        );
    }
}
// ***********************************************************************************************************
if (!function_exists('sidebar_open')) {
    function sidebar_open($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }
        return $open ? 'active' : '';
    }
}
// ***********************************************************************************************************
if (!function_exists('sidebar_menu_open')) {
    function sidebar_menu_open($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }
        return $open ? 'menu-is-opening menu-open' : '';
    }
}
// ***********************************************************************************************************
if (!function_exists('getCompany')) {
    function getCompany($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Companies::where('company_id', $companyId)->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($temple_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->registration_name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->registration_name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getCompanyUserList')) {
    function getCompanyUserList($id)
    {
        // dd($id);
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        // dd($companyId);
        $data = CompanyUser::where('company_id', $companyId)->get();
        foreach ($data as $key => $val) {
            // dd($val->companyUserRole->name);
            if ($val?->companyUserRole?->slug !== 'admin' && $val?->companyUserRole?->slug !== 'super-admin') {
                if ($id == $val->id) {
                    echo "<option value='" . $val->id . "' selected>" . $val->name . " -  " . $val->companyUserRole->name . "</option>";
                } else {
                    echo "<option value='" . $val->id . "' >" . $val->name . "  -  " . $val->companyUserRole->name . "</option>";
                }
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getCompanyUserLists')) {
    function getCompanyUserLists($selectedId = null)
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        // Fetch users belonging to the company
        $users = CompanyUser::where('company_id', $companyId)->get();

        // Initialize an empty string for options
        $options = '';

        foreach ($users as $user) {
            $selected = ($selectedId == $user->id) ? 'selected' : '';
            $options .= "<option value='{$user->id}' {$selected}>{$user->name}</option>";
        }
        return $options; // Return the generated options
    }
}

// ***********************************************************************************************************
if (!function_exists('getCompanyUser')) {
    function getCompanyUser($temple_id)
    {
        // dd($temple_id);
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = CompanyManagment::where('id', $companyId)->with('companyuser', 'companyuser.companyUserRole')->get();
        // dd($datas);
        foreach ($datas as $key => $vals) {
            // dd($vals->companyTeams);
            foreach ($vals->companyTeams as $key => $val) {
                // dd($val?->companyUserRole?->name);
                if (is_array($temple_id)) {
                    // if ($val?->companyUserRole?->slug !== 'admin' && $val?->companyUserRole?->slug !== 'super-admin') {
                    if (in_array($val->id, $temple_id)) {
                        echo "<option value='" . $val->id . "' selected>" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                    } else {
                        echo "<option value='" . $val->id . "' >" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                    }
                    // }
                } else {
                    // dd($val);
                    // if ($val?->companyUserRole?->slug !== 'admin' && $val?->companyUserRole?->slug !== 'super-admin') {
                    if ($temple_id == $val->id) {
                        echo "<option value='" . $val->id . "' selected>" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                    } else {
                        echo "<option value='" . $val->id . "' >" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                    }
                    // }
                }
            }
        }
    }
}

if (!function_exists('getCompanyStaff')) {
    function getCompanyStaff($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = CompanyManagment::where('id', $companyId)->with('companyuser', 'companyuser.companyUserRole')->get();
        foreach ($datas as $key => $vals) {
            foreach ($vals->companyTeams as $key => $val) {
                if ($val?->companyUserRole?->slug !== 'admin' && $val?->companyUserRole?->slug !== 'super-admin') {
                    if (is_array($temple_id)) {
                        if (in_array($val->id, $temple_id)) {
                            echo "<option value='" . $val->id . "' selected>" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                        } else {
                            echo "<option value='" . $val->id . "' >" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                        }
                    } else {
                        if ($temple_id == $val->id) {
                            echo "<option value='" . $val->id . "' selected>" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                        } else {
                            echo "<option value='" . $val->id . "' >" . $val->name . " - (" . $val?->companyUserRole?->name . ")</option>";
                        }
                    }
                }
            }
        }
    }
}
// ***********************************************************************************************************

if (!function_exists('getProjectManager')) {
    function getProjectManager($temple_id)
    {
        // Ensure $temple_id is an array
        $temple_id = is_array($temple_id) ? $temple_id : [$temple_id];

        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = CompanyManagment::where('id', $companyId)->with('companyuser', 'companyuser.companyUserRole')->get();

        foreach ($datas as $vals) {
            foreach ($vals->companyuser as $val) {
                if ($val->companyUserRole->slug == 'project-manager') {
                    if (in_array($val->id, $temple_id)) {
                        echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
                    } else {
                        echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
                    }
                }
            }
        }
    }
}



// ***********************************************************************************************************
if (!function_exists('getRole')) {
    function getRole($role_id)
    {
        // dd($role_id);
        $data = AdminRole::where('slug', '!=', 'super-admin')->get();
        foreach ($data as $key => $val) {
            if ($role_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getProject')) {
    function getProject($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Project::where('company_id', $companyId)->get();
        // $data = Project::where('id', $id)->where('company_id', $companyId)->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($temple_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->project_name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->project_name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getMaterials')) {
    function getMaterials($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Materials::where('company_id', $companyId)->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($temple_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getStoreWarehouseByProject')) {
    function getStoreWarehouseByProject($projectId)
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);
        $data = StoreWarehouse::where('projects_id', $projectId)
            ->where('company_id', $companyId)
            ->get();

        foreach ($data as $val) {
            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
        }
    }
}

// ***********************************************************************************************************
if (!function_exists('getchildActivites')) {
    function getchildActivites($p, $sp)
    {

        // Get the authenticated company's ID
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);
        // Query activities based on company ID, project ID, and optional subproject ID
        $data = Activities::where('company_id', $companyId)
            ->whereNull('parent_id')
            ->whereIn('type', ['heading', 'activities'])
            ->whereNotNull('project_id')->where('project_id', $p)->orWhere('subproject_id', $sp);
        // Fetch activities
        $fetchActivities = $data->get();
        // dd($fetchActivities);
        // Check if activities are not empty
        if ($fetchActivities->isNotEmpty()) {
            foreach ($fetchActivities as $activity) {
                if ($activity->type === 'heading') {
                    echo "<option class='groupHeading' value='" . $activity->id . "'>" . $activity->activities . "</option>";
                    // Check if the heading has children and display them
                    if ($activity->children->count()) {
                        foreach ($activity->children as $childActivity) {
                            echo "<option value='" . $childActivity->id . "'>" . $childActivity->activities . "</option>";
                        }
                    }
                }
            }
        }
        // dd($fetchActivities);
        // foreach ($data as $key => $val) {
        //     if ($val->type == 'heading') {
        //         echo "<option class='groupHeading' value='" . $val->id . "'>"  . $val->activities . "</option>"; // Close <option> tag properly
        //     }
        //     if (count($val->parentAndSelf) < 2) {
        //         foreach ($val->children as $childkey => $childval) {
        //             if ($childval->type == 'activites') {
        //                 echo "<option value='" . $childval->id . "'>"  . $childval->activities . "</option>"; // Close <option> tag properly
        //             }
        //         }
        //     }
        // }
        // dd($data->toArray());
    }
}
// ***********************************************************************************************************
// ***********************************************************************************************************
if (!function_exists('getHeading')) {
    function getHeading($heading_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        // $data = Activities::where('company_id', $companyId)->get();
        $data = Activities::with('parentActivites')->whereNull('parent_id')->where('company_id', $companyId)->get();
        if ($data->count() > 0) {
            foreach ($data as $key => $val) {
                // dd($val);
                echo "<option value='" . $val->id . "' >" . $val->activities . "</option>"; // Close <option> tag properly
            }
        } else {
            echo "<option value=''>No activities found</option>"; // Provide a message if no activities were found
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getStoreWarehouses')) {
    function getStoreWarehouses($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = StoreWarehouse::where('company_id', $companyId)->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($temple_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getTeams')) {
    function getTeams($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Teams::where('company_id', $companyId)->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($temple_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getProfileRole')) {
    function getProfileRole($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = profileDesignation::where('company_id', $companyId)->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($temple_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getUnits')) {
    function getUnits($unit_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Unit::where('company_id', $companyId)->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($unit_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->unit . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->unit . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getMenus')) {
    function getMenus($menu_id)
    {
        $data = HomePage::all();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($menu_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getSiteManag')) {
    function getSiteManag($site_id)
    {
        $data = PageManagment::where('slug', '!=', 'home')->get();
        // dd($data);
        foreach ($data as $key => $val) {
            if ($site_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->page_name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->page_name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getPages')) {
    function getPages($position, $type, $limit)
    {
        $data = MenuManagment::where([
            'position' => $position,
            'type' => $type,
            'is_active' => 1,
        ])->limit($limit)->get();
        // dd($data);
        return $data;
    }
}
// ***********************************************************************************************************
if (!function_exists('getAllMenu')) {
    function getAllMenu()
    {
        $data = MenuManagment::where('is_active', '1')->get();
        // dd($data);
        return $data;
    }
}
// ***********************************************************************************************************
if (!function_exists('getPageDetails')) {
    function getPageDetails($select, $id)
    {
        $data = PageManagment::select($select)->where('id', $id)->get();
        // dd($data);
        if (isset($data[0])) {
            return $data[0][$select];
        }
        return false;
    }
}
// ***********************************************************************************************************
if (!function_exists('getUnit')) {
    function getUnit()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Unit::where('is_active', '1')->where('company_id', $companyId)->pluck('unit')->toArray();
        // dd($data);
        return $data;
    }
}
// ***************************Activites*****************************************************
if (!function_exists('searchActivitiesToId')) {
    function searchActivitiesToId($data)
    {
        // dd( $data);
        $result = [];
        if ($data['activities_history_activities_id'] != null) {
            // dd( $data);
            $fetchActivitiesHistory = ActivityHistory::where('activities_id', $data['activities_history_activities_id'])->orderBy('id', 'DESC')->first();
            //    dd($fetchActivitiesHistory);
            $fetchActivities = Activities::where('id', $data['activities_history_activities_id'])->first();
            $dataExites = $fetchActivities ?? '';
            // dd($dataExites);
            $result['total_qty'] = $fetchActivitiesHistory?->total_qty == null ? $dataExites->qty : $dataExites->total_qty;
            $result['remaning_qty'] = $fetchActivitiesHistory?->remaining_qty == null ? ($dataExites->qty - $data['activities_history_qty']) : ($fetchActivitiesHistory?->remaining_qty - $data['activities_history_qty']);
            // dd($result);
            return $result;
        }
    }
}
// ***************************Materials*****************************************************
if (!function_exists('searchMaterialsToId')) {
    function searchMaterialsToId($data)
    {
        // dd( $data['materials_id']);
        $result = [];
        if ($data['materials_id'] != null) {
            // dd( $data);
            $fetchMaterialsHistory = MaterialsHistory::where('materials_id', $data['materials_id'])->orderBy('id', 'DESC')->first();
            //    dd($fetchMaterialsHistory);
            $fetchMaterials = Materials::where('id', $data['materials_id'])->first();
            $dataExites = $fetchMaterials ?? '';
            // dd($dataExites);
            $result['total_qty'] = $fetchMaterialsHistory?->total_qty == null ? $dataExites->qty : $dataExites->total_qty;
            $result['remaning_qty'] = $fetchMaterialsHistory?->remaining_qty == null ? ($dataExites->qty - $data['qty']) : ($fetchMaterialsHistory?->remaining_qty - $data['qty']);
            return $result;
        }
    }
}
// ********************************************************************************
function buildCategoryTreeHtml($categories, $number = 1)
{
    $options = '<ul>';
    if (count($categories)) {
        foreach ($categories as $key => $category) {
            $options .= '<li>' . $category->activities . '</li>';
            if ($category->children->isNotEmpty()) {
                $options .= buildCategoryTreeHtml($category->children);
            }
        }
        $options .= '</ul>';
    }
    return $options;
}
// ***********************************************************************************************************
// ***************************Company*****************************************************
if (!function_exists('getCompanyRole')) {
    function getCompanyRole($role_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        // dd($role_id);
        $data = Company_role::where('slug', '!=', 'super-admin')->where('company_id', $companyId)->get();
        foreach ($data as $key => $val) {
            if ($role_id == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('searchCompanyId')) {
    function searchCompanyId($authConpany)
    {
        // dd($authConpany);
        $employees = CompanyUser::findOrFail($authConpany);
        $companyId = $employees->company_id;
        // dd($companyId);
        return $companyId;
    }
}
// ******************************Activites***************************************************
if (!function_exists('getSubheading')) {
    function getSubheading($id)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;

        $data = Activities::where('parent_id', $id)->where('company_id', $authCompany)->get();
        return $data;
    }
}
// ***********************************************************************************************************
if (!function_exists('getActivite')) {
    function getActivite($id)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $data = Activities::where('parent_id', $id)->where('company_id', $authCompany)->get();
        // dd($data);
        return $data;
    }
}
// *****************************Location****************************************************************************
if (!function_exists('getCountries')) {
    function getCountries($countryId)
    {
        $data = Countries::all();
        foreach ($data as $key => $val) {
            if ($countryId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getStates')) {
    function getStates($countryId)
    {
        $data = States::where('country_id', $countryId)->get();
        foreach ($data as $key => $val) {
            if ($countryId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getCities')) {
    function getCities($stateId)
    {
        $data = Cities::where('state_id', $stateId)->get();
        foreach ($data as $key => $val) {
            if ($stateId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ********************************Subscription************************************************************************
if (!function_exists('getSubscription')) {
    function getSubscription($subscriptionId)
    {
        $data = SubscriptionPackage::all();
        // dd($data);
        foreach ($data as $key => $val) {
            // if (checkSubscriptionOption($val->id)) {
            if ($subscriptionId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->title . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->title . "</option>";
            }
            // }
        }
    }
}
if (!function_exists('checkSubscriptionOption')) {
    function checkSubscriptionOption($subscriptionId)
    {
        $data = SubscriptionPackageOptions::where('subscription_packages_id', $subscriptionId)->first();
        // dd($data);
        if (isset($data)) {
            return false;
        }
        return true;
    }
}
// *****************************************************************************************************
if (!function_exists('getFreeSubscribeId')) {
    function getFreeSubscribeId($id)
    {
        $data = SubscriptionPackage::where('free_subscription', 1)->first();
        return $data;
    }
}
// ************************************************************************************************
if (!function_exists('checkSubscribePackage')) {
    function checkSubscribePackage($id)
    {
        $date = Carbon::now()->format('Y-m-d');
        // dd($id);
        $data = CompanyManagment::where('id', $id)->first();
        // $subId = SubscriptionCompany::where('company_id',  $data->id)
        //     ->whereDate('from_date', '<', $date)
        //     ->whereDate('to_date', '>', $date)
        //     ->where('is_active', 1)
        //     ->first();
        // dd($data);
        $freeOrPaid = checkSubscription($data?->is_subscribed);
        // dd($freeOrPaid);
        // to_date, from_date
        //$freeOrPaid is null then rediract abort or rediract back previous page
        // dd($freeOrPaid);
        if ($freeOrPaid == null) {
            return false;
        } else {
            return $freeOrPaid;
        }
    }
}
// // ************************************************************************************************
if (!function_exists('checkMySubscribePackage')) {
    function checkMySubscribePackage($id)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        // dd($authCompany);
        $data = SubscriptionCompany::where('company_id', $authCompany)->where('is_subscribed', $id)->first();
        // dd($data);
        return $data;
    }
}
// // ************************************************************************************************
if (!function_exists('checkFreeSubscribePackage')) {
    function checkFreeSubscribePackage($data)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        // dd($authCompany);
        $data = SubscriptionCompany::where('company_id', $authCompany)->where('is_use_free_subscription', 1)->first();
        // dd($data);
        return $data;
    }
}
// ************************************************************************************************
if (!function_exists('checkSubscription')) {
    function checkSubscription($id)
    {
        // dd($id);
        $data = SubscriptionPackage::where('id', $id)->first();
        // dd($data);
        // if ($data == null) {
        //     abort(404);
        // } else {
        return $data;
        // }
    }
}
// **************************check Free Subscription*******************************************************
if (!function_exists('checkFreeSubscription')) {
    function checkFreeSubscription()
    {
        $data = SubscriptionPackage::where('free_subscription', 1)->first();
        return isset($data->free_subscription);
    }
}
// **************************Check  Subscription*******************************************************
if (!function_exists('checkSubscriptionPermission')) {
    function checkSubscriptionPermission($companyId, $key)
    {
        $subscriptionId = checkSubscribePackage($companyId);
        if ($subscriptionId->free_subscription != 1) {
            $data = SubscriptionPackageOptions::where('subscription_packages_id', $subscriptionId->id)->where('subscription_key', $key)->first();
            return $data;
        }
    }
}
// *********************************************************************************************
if (!function_exists('isSubscriptionTrial')) {
    function isSubscriptionTrial($id)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $iSExpire = SubscriptionCompany::where('company_id', $authCompany)->first();
        if (isset($iSExpire) && $iSExpire->is_subscribed == $id) {
            $today = Carbon::now()->format('Y-m-d');
            $from_date = Carbon::parse($iSExpire->trial_start);
            $to_date = Carbon::parse($iSExpire->trial_end);
            $diff = $to_date->diffInDays($today);
            // if ($diff < 200) {
            if ($to_date > $today) {
                // dd($diff,$iSExpire);
                // if ($diff < $iSExpire->subscriptionPackage->trial_period) {
                return $diff;
            }
        }
        return 0;
    }
}
// *********************************************************************************************
if (!function_exists('isSubscriptionExpire')) {
    function isSubscriptionExpire($data)
    {
        $durationInDays = '';
        $date = Carbon::now()->format('Y-m-d');
        $authConpany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->id;
        $iSExpire = SubscriptionCompany::where('company_id', $authConpany)
            // ->whereDate('from_date', '<=', $date)
            // ->whereDate('to_date', '>=', $date)
            ->first();
        if ($iSExpire == null) {
            $isFreeSubscription = getFreeSubscribeId('');
            $iSExpire = SubscriptionCompany::where('company_id', $authConpany)->first();
            $isUpdate = $iSExpire->update([
                'is_subscribed' => $isFreeSubscription->id,
                'type' => 'Free',
                'status' => 0
            ]);
        }
    }
}
// *********************************************************************************************
if (!function_exists('addSubscriptionLogs')) {
    function addSubscriptionLogs($data)
    {
        // dd($data);
        SubscriptionLogs::create($data);
    }
}
// *********************************************************************************************

if (!function_exists('addSubscriptionTranction')) {
    function addSubscriptionTranction($data)
    {
        // dd($data);
        $fetchData = [
            'transaction_id' => $data['payment_data']['id'] ?? " ",
            'payment_method' => $data['payment_data']['method'] ?? " ",
            'payment_status' => $data['payment_data']['status'] ?? " ",
            'payment_amount' => $data['payment_data']['amount'] ?? " ",
            'payment_date' => $data['payment_data']['created_at'] ?? " ",
            'subscription_type' => $data['type'] ?? '',
            'subscription_companie_id' => $data['subscriptionCompany'] != null ? $data['subscriptionCompany']['id'] : NULL,
            'company_id' => $data['company_id'] ?? NULL,
            'company_user_id' => $data['user_id'] ?? NULL,
            'payment_data' => $data['payment_data'] ?? "",
        ];
        $swderfghj = Transaction::create($fetchData);
        // dd($swderfghj);

        // SubscriptionLogs::create($data);
    }
}
// *****************************Fetch Data and count************************************************
if (!function_exists('fetchData')) {
    function fetchData($companyId, $table)
    {
        $dbDetails = DB::table($table)
            ->where('company_id', $companyId)->get();
        if ($dbDetails) {
            return $dbDetails;
        } else {
            abort(404);
        }
    }
}
function findDatacustomflied($fieldName, $fieldVal)
{
    $companyId = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
    $query = InwardGoods::where($fieldName, $fieldVal)
        ->where('company_id', $companyId);
    // dd($query);
    if ($query) {
        return $query;
    } else {
        abort(404);
    }
}
// ***********************************************************************************************************
if (!function_exists('fetchDataActivities')) {
    function fetchDataActivities($companyId, $project)
    {
        // $data['companyId'] = $companyId;
        // $data['project'] = $project;
        // $data['key'] = $key;
        // return $data;
        $dbDetails = Activities::where('company_id', $companyId)->where('project_id', $project)->where('type', 'activites')->get();
        if ($dbDetails) {
            return $dbDetails;
        } else {
            abort(404);
        }
    }
}
// **********************Subscription Activities**************************************
// ************************contact deails show****************************************
if (!function_exists('contactDetails')) {
    function contactDetails()
    {
        $datas = ContactDetails::first();
        if ($datas) {
            return $datas;
        } else {
            return;
            // abort(404);
        }
    }
}
// *********************************************************************************
if (!function_exists('getProjectWiseSubProject')) {
    function getProjectWiseSubProject($project, $subproject)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Project::with('subProject')->where('company_id', $companyId)->get();
        // dd($data);
    }
}
// *********************************************************************************
if (!function_exists('getdprcheck')) {
    function getdprcheck($data)
    {
        // dd($data);
        $authCompany = Auth::guard('company-api')->user();
        $date = Carbon::now()->format('Y-m-d');
        $datas = Dpr::where('staps', '!=', 7)
            ->where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)
            ->where('id', $data)
            // ->where('date', $date)
            ->orderBy('id', 'desc')
            ->first();
        return $datas;
    }
}
// *********************************************************************************
if (!function_exists('dprHistoryEdit')) {
    function dprHistoryEdit($data)
    {
        // dd($data->all());
        if ($data->post()) {
            $type = $data->type;
            $data = $data->dprId;
            switch ($type) {
                case 1: //activity
                    $activityHistory = ActivityHistory::where('dpr_id', $data)->orderBy('id', 'desc')->get();
                    $data = DprActivitesResources::collection($activityHistory);
                    $message = 'Fetch Activities History';
                    break;
                case 2: //materials
                    $metirialHistory = MaterialsHistory::where('dpr_id', $data)->orderBy('id', 'desc')->get();
                    $data = DprMaterialsResources::collection($metirialHistory);
                    $message = 'Fetch Materials History';
                    break;
                case 3: //labour
                    $labourHistory = LabourHistory::where('dpr_id', $data)->orderBy('id', 'desc')->get();
                    $data = DprLabourResources::collection($labourHistory);
                    $message = ' Fetch labour History';
                    break;
                case 4: //assets
                    $assetsHistory = AssetsHistory::where('dpr_id', $data)->orderBy('id', 'desc')->get();
                    $data = DprAssetsResources::collection($assetsHistory);
                    $message = ' Fetch Assets History';
                    break;
                case 5: //safeties
                    // $data = User::where('id', $id)->update(['is_active' => $data->is_active]);
                    $message = ' Fetch Safeties History';
                    break;
                case 6: //hinderance
                    // $data = User::where('id', $id)->update(['is_active' => $data->is_active]);
                    $message = ' Fetch Hinderance History';
                    break;
                default:
                    // return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
            // dd($data);
            if ($data) {
                return $data;
            } else {
                // return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        }
        abort(405);
    }
}
// *************************PDF********************************************************
function generateAndSavePDF($view, $data, $filename, $options = [])
{
    // Load the Blade template with data
    $pdf = PDF::loadView($view, $data);
    // Set any additional options
    foreach ($options as $option => $value) {
        $pdf->setOptions([$option => $value]);
    }
    // Save the PDF to a file
    $pdfPath = storage_path('app/public/pdf/' . $filename);
    $pdf->save($pdfPath);
    return $pdfPath;
}
// *********************************unit************************************************
if (!function_exists('nametoid')) {
    function nametoid($name, $table)
    {
        $authConpany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->id;
        $dbDetails = DB::table($table)
            ->select('id')
            ->where('unit', 'LIKE', "%{$name}%")->where('company_id', $authConpany)->first();
        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            return false;
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('unitnametoid')) {
    function unitnametoid($name, $company)
    {
        $dbDetails = DB::table('units')
            ->select('id')
            ->where('company_id', $company)
            ->where('unit', 'LIKE', "%{$name}%")->first();
        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            return createunit($name, $company);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('idtoname')) {
    function idtoname($id, $filed, $table)
    {
        $dbDetails = DB::table($table)
            ->where('id', $id)->first();
        if ($dbDetails) {
            return $dbDetails->$filed;
        } else {
            return false;
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('createunit')) {
    function createunit($data, $companyId)
    {
        $dbDetails = Unit::create([
            'uuid' => Str::uuid(),
            'unit' => $data,
            'company_id' => $companyId
        ]);
        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('companyroleidtoname')) {
    function companyroleidtoname($id, $table)
    {
        if ($id != null) {
            $dbDetails = DB::table($table)
                ->select('name')
                ->where('id', $id)->first();
            if ($dbDetails) {
                return $dbDetails->name;
            } else {
                abort(404);
            }
        }
    }
}

// ********************************************************************************
if (!function_exists('createSlug')) {
    function createSlug($cid)
    {
        $isRoleCreated = Company_role::create([
            'name' => 'Super Admin',
            'slug' => Str::slug('Super Admin'),
            'company_id' => $cid
        ]);
        return $isRoleCreated->id;
    }
}
if (!function_exists('findAdmin')) {
    function findAdmin()
    {
        $isRoleCreated = User::whereHas('role', function ($query) {
            $query->where('slug', 'super-admin');
        })->first();

        return $isRoleCreated;
    }
}
// ********************************************************************************
if (!function_exists('isSubscribedFree')) {
    function isSubscribedFree()
    {
        $date = Carbon::now()->format('Y-m-d');
        $authConpany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->id;
        $companyId = SubscriptionCompany::where('company_id', $authConpany) // Use $authCompanyId for consistency
            ->where(function ($q) use ($date) {
                // Check if the subscription is active
                $q->where('status', 1)
                    ->whereDate('from_date', '<=', $date)
                    ->whereDate('to_date', '>=', $date);
            })
            ->orWhere(function ($q) use ($date) {
                // Check if the trial is active
                $q->where('is_trial', 1)
                    ->whereDate('trial_start', '<=', $date)
                    ->whereDate('trial_end', '>=', $date);
            })
            ->where(function ($subQuery) {
                // Check for subscription packages
                $subQuery->whereHas('subscriptionPackage', function ($pkgQuery) {
                    $pkgQuery->where('free_subscription', 0); // Paid subscription
                })
                    ->orWhere(function ($freeQuery) {
                        $freeQuery->whereHas('subscriptionPackage', function ($pkgQuery) {
                            $pkgQuery->where('free_subscription', 1) // Free subscription
                                ->whereHas('subscriptionPackageOption', function ($optionQuery) {
                                    $optionQuery->where('subscription_key', 'web_app')
                                        ->where('is_subscription', 'yes');
                                });
                        });
                    });
            })
            ->first();






        //     $companyId = SubscriptionCompany::where('company_id', $authConpany)
        //    ->where(function ($q) use ($date) {
        //         $q->where('is_trial', 1)
        //         ->whereDate('trial_start', '<=', $date)
        //         ->whereDate('trial_end', '>=', $date);
        //     })
        //     ->orWhere(function ($q) use ($date) {
        //         // Check if the subscription is active
        //         $q->where('status', 1)
        //         ->whereDate('from_date', '<=', $date)
        //         ->whereDate('to_date', '>=', $date);
        //     })->where(function ($subQuery) {
        //         $subQuery->whereHas('subscriptionPackage', function ($pkgQuery) {
        //             $pkgQuery->where('free_subscription', 0); // Paid subscription
        //         })
        //         ->orWhere(function ($freeQuery) {
        //             $freeQuery->whereHas('subscriptionPackage', function ($pkgQuery) {
        //                 $pkgQuery->where('free_subscription', 1) // Free subscription
        //                     ->whereHas('subscriptionPackageOption', function ($optionQuery) {
        //                         $optionQuery->where('subscription_key', 'web_app')
        //                                     ->where('is_subscription', 'yes');
        //                     });
        //             });
        //         });
        //     })
        // ->first();

        // $companyId = SubscriptionCompany::where('company_id', $authConpany)
        //     ->whereDate('from_date', '<=', $date)
        //     ->whereDate('to_date', '>=', $date)
        //     ->where('status', 1)
        //     ->where(function ($query) {
        //         $query->whereHas('subscriptionPackage', function ($dsw) {
        //             $dsw->where('free_subscription', 0); // paid
        //         })
        //             ->orWhereHas('subscriptionPackage', function ($dsw) {
        //                 $dsw->where('free_subscription', 1) // free
        //                     ->whereHas('subscriptionPackageOption', function ($optionQuery) {
        //                         $optionQuery->where('subscription_key', 'web_app');
        //                         $optionQuery->where('is_subscription', 'yes');
        //                     });
        //             });
        //     })->first();
        // if ($companyId != null) {
        //     return true;
        // } else {
        //     return false;
        // }
        $return = $companyId != null ? true : false;
        return $return;
    }
}
// ********************************************************************************
if (!function_exists('createSlug')) {
    function createSlug($string)
    {
        // $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $string));
        //  dd($slug);
        // return $slug;
    }
}
// ********************************************************************************

// ***********************************************************************************************************
if (!function_exists('genrateOtp')) {
    function genrateOtp($digit = 4)
    {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $digit; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }
}
// ***********************************************************************************************************
if (!function_exists('genrateUniqueNo')) {
    function genrateUniqueNo()
    {
        $time = strtotime('today');
        $my = str_shuffle($time);
        return $my;
    }
}
// *************************************************************
if (!function_exists('generateUniqueSixDigitNumber')) {
    function generateUniqueSixDigitNumber($table, $colname)
    {
        do {
            // Generate a random 6-digit number
            $uniqueNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (DB::table($table)->where($colname, $uniqueNumber)->exists());
        return $uniqueNumber;
    }
}
// ***********************************************************************************************************
// if (!function_exists('getS3URL')) {
//     function getS3URL($filePath, $fileType = '', $fileAccessMode = 'private')
//     {
//         $storageDisk = Storage::disk('s3');
//         if ($storageDisk->exists($filePath)) {
//             if ($fileAccessMode == 'public') {
//                 $url = $storageDisk->url($filePath);
//             } else if ($fileAccessMode == 'private') {
//                 $url = $storageDisk->temporaryUrl(
//                     $filePath,
//                     now()->addMinutes(10080)
//                 );
//             }
//             return $url;
//         } else {
//             if ($fileType == 'profilePicture') {
//                 return asset('assets/frontend/images/no-profile-picture.jpeg');
//             } else if ($fileType == 'postImage') {
//                 return asset('assets/frontend/images/no-image-medium.png');
//             } else if ($fileType == 'collectionImage') {
//                 return asset('assets/frontend/images/no-image-small.png');
//             } else if ($fileType == 'profilePhotoId') {
//                 return asset('assets/frontend/images/file-not-found.png');
//             } else if ($fileType == 'cityImage') {
//                 return asset('assets/frontend/images/location-placeholder.jpeg');
//             } else {
//                 return false;
//             }
//         }
//     }
// }
// ***********************************************************************************************************
if (!function_exists('imageResizeAndSave')) {
    function imageResizeAndSave($imageUrl, $type = 'post/image', $filename = null)
    {
        if (!empty($imageUrl)) {
            Storage::disk('public')->makeDirectory($type . '/60x60');
            $path60X60 = storage_path('app/public/' . $type . '/60x60/' . $filename);
            $imageInstance = new Image(); // Create an instance of the Image class
            $image = $imageInstance->make($imageUrl)->resize(
                null,
                60,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            //$canvas->insert($image, 'center');
            $image->save($path60X60, 70);
            //save 350X350 image
            Storage::disk('public')->makeDirectory($type . '/350x350');
            $path350X350 = storage_path('app/public/' . $type . '/350x350/' . $filename);
            $image = $imageInstance->make($imageUrl)->resize(
                null,
                350,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $image->save($path350X350, 75);
            return $filename;
        } else {
            return false;
        }
    }
}

// if (!function_exists('siteSetting')) {
//     function siteSetting($key = '')
//     {
//         return \App\Models\Setting\Setting::where('key', $key)->value('value');
//     }
// }
// ***********************************************************************************************************
if (!function_exists('uuidtoid')) {
    function uuidtoid($uuid, $table)
    {
        $dbDetails = DB::table($table)
            ->select('id')
            ->where('uuid', $uuid)->first();
        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('fetchid')) {
    function fetchid($id, $filed, $table)
    {
        $dbDetails = DB::table($table)
            ->select($filed)
            ->where('id', $id)->first();
        // dd($dbDetails);
        if ($dbDetails) {
            return $dbDetails->$filed;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('slugtoname')) {
    function slugtoname($slug, $table)
    {
        $dbDetails = DB::table($table)
            ->select('name')
            ->where('slug', $slug)->first();
        if ($dbDetails) {
            return $dbDetails->name;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('slugtoid')) {
    function slugtoid($slug, $table)
    {
        $dbDetails = DB::table($table)
            ->select('id')
            ->where('slug', $slug)->first();
        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('nametoslug')) {
    function nametoslug($name, $table)
    {
        $dbDetails = DB::table($table)
            ->select('slug')
            ->where('name', $name)->first();
        // return $dbDetails;
        if ($dbDetails) {
            return $dbDetails->slug;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('slugtoid')) {
    function slugtoid($slug, $table)
    {
        $dbDetails = DB::table($table)
            ->select('id')
            ->where('slug', $slug)->first();
        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('customfind')) {
    function customfind($id, $table)
    {
        $dbDetails = DB::table($table)
            ->find($id);
        if ($dbDetails) {
            return $dbDetails;
        } else {
            abort(404);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('safe_b64encode')) {
    function safe_b64encode($string)
    {
        $pretoken = "";
        $posttoken = "";
        $codealphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codealphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codealphabet .= "0123456789";
        $max = strlen($codealphabet); // edited
        for ($i = 0; $i < 3; $i++) {
            $pretoken .= $codealphabet[rand(0, $max - 1)];
        }
        for ($i = 0; $i < 3; $i++) {
            $posttoken .= $codealphabet[rand(0, $max - 1)];
        }
        $string = $pretoken . $string . $posttoken;
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }
}
// ***********************************************************************************************************
if (!function_exists('safe_b64decode')) {
    function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        $data = base64_decode($data);
        $data = substr($data, 3);
        $data = substr($data, 0, -3);
        return $data;
    }
}
// ***********************************************************************************************************
if (!function_exists('customEcho')) {
    function customEcho($str, $length)
    {
        if (strlen($str) <= $length) {
            return $str;
        } else {
            return substr($str, 0, $length) . '...';
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('trasactionPriceBreakUp')) {
    function trasactionPriceBreakUp($purchaseItemPrice)
    {
        $purchaseItemVatPrice = 0;
        $purchaseItemVatPrice = 0;
        $purchaseItemTotalPrice = ($purchaseItemPrice + $purchaseItemVatPrice);
        return [
            'purchaseItemPrice' => $purchaseItemPrice,
            'purchaseItemVatPrice' => $purchaseItemVatPrice,
            'purchaseItemTotalPrice' => $purchaseItemTotalPrice,
        ];
    }
}
// ***********************************************************************************************************
if (!function_exists('formatTime')) {
    function formatTime($time)
    {
        return Carbon::parse($time)->format('dS M, Y, \\a\\t\\ g:i A');
    }
}
// ***********************************************************************************************************
// if (!function_exists('getSiteSetting')) {
//     function getSiteSetting($key)
//     {
//         return \App\Models\Setting\Setting::where('key', $key)->value('value');
//     }
// }
if (!function_exists('mime_check')) {
    function mime_check($path)
    {
        if ($path) {
            $typeArray = explode('.', $path);
            $fileType = strtolower($typeArray[count($typeArray) - 1]) ?? 'jpg';
            switch ($fileType) {
                case 'png':
                    $image = 'image/png';
                    break;
                case 'jpg':
                    $image = 'image/jpg';
                    break;
                case 'jpeg':
                    $image = 'image/jpg';
                    break;
                case 'webp':
                    $image = 'image/webp';
                    break;
                case 'mp4':
                    $image = 'video/mp4';
                    break;
                case 'webm':
                    $image = 'video/webm';
                    break;
                default:
                    $image = 'image/*';
                    break;
            }
            return $image;
        }
        return 'image/*';
    }
}
// ***********************************************************************************************************
if (!function_exists('getVideoCode')) {
    function getVideoCode($url)
    {
        if (str_contains($url, '?v=')) {
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
            return $my_array_of_vars['v'];
        } else {
            parse_str(parse_url($url, PHP_URL_PATH), $my_array_of_vars);
            return preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', array_keys($my_array_of_vars)[0]);
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getSliderImg')) {
    function getSliderImg($files, $pageName, $pageId)
    {
        $temple_img = [];
        foreach ($files as $file) {
            $name = time() . rand(1, 100) . '.' . $file->extension();
            $file->move(public_path('temple_img'), $name);
            $temple_img[] = [
                'uuid' => Str::uuid(),
                'user_id' => auth()->user()->id,
                'file_name' => $name,
                'page_name' => $pageName,
                'media_type' => 'image',
                'media_id' => '',
                'page_id' => $pageId,
                'media_path' => $file,
            ];
        }
        return $temple_img;
    }
}
// ***********************************************************************************************************
if (!function_exists('getthumbnailImg')) {
    function getthumbnailImg($file)
    {
        // dd($file);
        $name = time() . rand(1, 100) . '.' . $file->extension();
        $file->move(public_path('logo'), $name);
        // $isSubjectCreated= media()->create([
        //     'user_id' => auth()->user()->id,
        //     'media_type' => 'image',
        //     'file' => $name,
        //     'alt_text' =>  NULL,
        //     'is_profile_picture' => false,
        // ]);
        // dd($isSubjectCreated);
        return $name;
    }
}
// ***********************************************************************************************************
if (!function_exists('deleteFile')) {
    function deleteFile($id, $table, $select, $path)
    {
        $fetchFile = DB::table($table)->select($select)->where('id', $id)->first();
        $existingArabicFile = $path . '/' . $fetchFile?->$select ?? '';
        // return $existingArabicFile;
        if (File::exists(public_path($existingArabicFile))) {
            File::delete(public_path($existingArabicFile));
        }
        return false;
    }
}
// ***********************************************************************************************************
// if (!function_exists('getImgUpload')) {
//     function getImgUpload($file, $location)
//     {
//         $name = time() . rand(1, 100) . '.' . $file->extension();
//         $file->move(public_path($location), $name);
//         return $name;
//     }
// }
// ***********************************************************************************************************
if (!function_exists('getImgUpload')) {
    function getImgUpload($file, $location)
    {
        if ($file != null && is_object($file) && method_exists($file, 'isValid')) {
            $name = time() . rand(1, 100) . '.' . $file->extension();
            $file->move(public_path($location), $name);
            return $name;
        }
    }
}
// ***********************************************************************************************************

if (!function_exists('base64ImageUpload')) {
    function base64ImageUpload($base64String, $location)
    {
        if (isset($base64String)) {
            $clinicImage = base64_decode($base64String);
            $image = uniqid() . ".png";
            $storagePath = public_path($location . '/' . $image);
            file_put_contents($storagePath, $clinicImage);
            return $image;
        }
        // // Check if the base64 string is valid
        // if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
        //     $data = substr($base64String, strpos($base64String, ',') + 1);
        //     $type = strtolower($type[1]); // jpg, png, gif
        //     // Decode the base64 string
        //     $data = base64_decode($data);
        //     if ($data === false) {
        //         return false; // Return false if decoding fails
        //     }
        //     // Generate a unique name for the file
        //     $name = time() . rand(1, 100) . '.' . $type;
        //     // Save the file to the specified location
        //     $filePath = public_path($location) . '/' . $name;
        //     file_put_contents($filePath, $data);
        //     return $name; // Return the name of the saved file
        // }
        // return false; // Return false if the base64 string is not valid
    }
}
// *******************************Inventory********************************************************
if (!function_exists('inventoryDataChecking')) {
    function inventoryDataChecking($data)
    {
        // dd($data);
        $authCompany = Auth::guard('company-api')->user()->company_id;
        if (isset($data['type']) && $data['type'] == 'materials') {
            $data = Inventory::where('projects_id', $data['projects_id'])
                ->where('materials_id', $data['materials_id'])
                ->where('company_id', $authCompany)
                ->first();
            // dd($data);
        } else {
            $data = Inventory::where('projects_id', $data['projects_id'])
                ->where('assets_id', $data['materials_id'])
                ->where('company_id', $authCompany)
                ->first();
        }
        // dd($data);
        return $data;
    }
}
// ***************************Dashboard function**********************************************************************
// if (!function_exists('projectwisedpr')) {
//     function projectwisedpr($data)
//     {
//         // dd($data);
//         $workStatus = [];
//         $inProgress = 0;
//         $completed = 0;
//         // $authCompany = Auth::guard('company-api')->user()->company_id;
//         $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
//         $fetchActivites = Activities::with('activitiesHistory')->where('company_id', $authCompany)
//             ->where('project_id', $data['project'])
//             ->where('type', 'activites')
//             ->get();
//         // dd($fetchActivites->count());
//         foreach ($fetchActivites as $val) {
//             if (($val->activitiesHistory)->count() > 0) {
//                 $asdfgh = collect($val->activitiesHistory)->sum(function ($item) {
//                     return (float) $item->qty;
//                 });
//                 if ($val->qty == $asdfgh) {
//                     $completed = $completed + 1;
//                 }
//             }
//             if (($val->activitiesHistory)->count() > 0) {
//                 $inProgress = $inProgress + 1;
//             }
//         }
//         $workStatus['totalActivites'] = $fetchActivites->count();
//         $workStatus['inProgress'] = $inProgress;
//         $workStatus['notStart'] = (($fetchActivites->count() - $inProgress) - $completed);
//         $workStatus['completed'] = $completed;
//         // dd($workStatus);
//         return $workStatus;
//     }
// }

if (!function_exists('projectwisedpr')) {
    function projectwisedpr($data)
    {
        $authCompany = Auth::guard('company')->user()?->company_id
            ?? Auth::guard('company-api')->user()?->company_id;

        $activities = Activities::with('activitiesHistory')
            ->where('company_id', $authCompany)
            ->where('project_id', $data['project'])
            ->where('type', 'activites')
            ->get();

        $total = $activities->count();
        $completed = 0;
        $inProgress = 0;
        $notStart = 0;

        foreach ($activities as $activity) {
            $totalQty = $activity->activitiesHistory->sum(function ($item) {
                return (float) ($item->qty ?? 0);
            });

            $plannedQty = (float) ($activity->qty ?? 0);

            if ($totalQty >= $plannedQty && $plannedQty > 0) {
                // Fully completed (only if plannedQty > 0 to avoid division by zero or false positives)
                $completed++;
            } elseif ($totalQty > 0) {
                // Some work done, but not finished
                $inProgress++;
            } else {
                // No work reported (or zero qty)
                $notStart++;
            }
        }

        return [
            'totalActivites' => $total,
            'completed'      => $completed,
            'inProgress'     => $inProgress,
            'notStart'       => $notStart,
        ];
    }
}


// ***********************************************************************************************************
// if (!function_exists('activitesWorkDetails')) {
//     function activitesWorkDetails($data)
//     {
//         $workStatus = [];
//         $inProgress = [];
//         $completed = [];
//         $notStart = [];
//         $delayactivites = [];
//         $currentDate = Carbon::now();
//         $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
//         $fetchActivites = Activities::with('activitiesHistory')->where('company_id', $authCompany)
//             ->where('project_id', $data['project'])
//             ->whereIn('type', ['activites'])
//             ->get();
//         foreach ($fetchActivites as $val) {
//             if (($val->activitiesHistory)->count() > 0) {
//                 $totalQty = collect($val->activitiesHistory)->sum(function ($item) {
//                     return (float) $item->qty;
//                 });
//                 if (($val->qty == $totalQty || $val->qty <= $totalQty) && ($val->end_date >= $currentDate)) {
//                     $completed[] = $val;
//                 } elseif (($totalQty <= $val->qty) && ($currentDate <= $val->end_date)) {
//                     $inProgress[] = $val;
//                 } elseif (($totalQty == 0 && $totalQty == null) && ($currentDate <= $val->end_date)) {
//                     $notStart[] = $val;
//                 } elseif (($totalQty <= $val->qty) && ($currentDate >= $val->end_date)) {
//                     $delayactivites[] = $val;
//                 } else {
//                     $workStatus[] = $val;
//                 }
//             }
//         }
//         dd($delayactivites);
//         return compact(
//             'completed',
//             'inProgress',
//             'notStart',
//             'delayactivites'
//         );
//     }
// }

if (!function_exists('activitesWorkDetails')) {
    function activitesWorkDetails($data)
    {
        $completed = [];
        $inProgress = [];
        $notStart = [];
        $delayactivites = [];

        $currentDate = now(); // Carbon instance (Laravel helper)
        $authCompany = Auth::guard('company')->user()?->company_id
            ?? Auth::guard('company-api')->user()?->company_id;

        $fetchActivites = Activities::with('activitiesHistory')
            ->where('company_id', $authCompany)
            ->where('project_id', $data['project'])
            ->where('type', 'activites') // No need for inArray if single value
            ->get();

        foreach ($fetchActivites as $val) {
            // Calculate total completed quantity from history
            $totalQty = $val->activitiesHistory->sum(function ($item) {
                return (float) ($item->qty ?? 0);
            });

            $plannedQty = (float) ($val->qty ?? 0);
            $isCompleted = $totalQty >= $plannedQty;
            $isOverdue = $currentDate->gt($val->end_date ?? $currentDate);

            // 1. Completed: fully done (even if overdue, it's still completed)
            if ($isCompleted) {
                $completed[] = $val;
            }
            // 2. Delayed: not completed AND past end date
            elseif ($isOverdue) {
                $delayactivites[] = $val;
            }
            // 3. Not Started: no work done yet AND end date hasn't passed
            elseif ($totalQty == 0) {
                $notStart[] = $val;
            }
            // 4. In Progress: some work done, not overdue, not finished
            else {
                $inProgress[] = $val;
            }
        }

        // Optional: uncomment to debug
        // dd([
        //     'completed' => $completed,
        //     'inProgress' => $inProgress,
        //     'notStart' => $notStart,
        //     'delayactivites' => $delayactivites,
        // ]);

        // dd($completed, $inProgress, $notStart, $delayactivites);
        return compact('completed', 'inProgress', 'notStart', 'delayactivites');
    }
}
// ***********************************************************************************************************

// ***********************************************************************************************************
if (!function_exists('timelineProgress')) {
    function timelineProgress($data)
    {
        $currentDate = Carbon::now();
        $fetchproject = Project::where('id', $data['project'])->first();
        // dd($fetchproject);
        $startDate = Carbon::parse($fetchproject->planned_start_date);
        $endDate = Carbon::parse($fetchproject->planned_end_date);
        // dd($fetchproject->activites);
        $fetchActivites = collect($fetchproject->activites)->whereIn('type', ['activites'])->pluck('end_date');
        $totalDuration = $startDate->diffInDays($endDate);
        $projectcompleted = $startDate->diffInDays($currentDate);

        // Corrected calculation for remaining days and progress percentages
        $remaining = max(0, $totalDuration - $projectcompleted); // Ensure remaining is not negative
        // $planeProgress = $totalDuration > 0 ? number_format(($projectcompleted / $totalDuration) * 100, 2) : 0; // Avoid division by zero
        // $actualProgress = number_format($planeProgress, 2); // Assuming actual progress is the same as planned progress for now
        // $variation = number_format($planeProgress - $actualProgress, 2); // This will always be 0 in this case

        $planeProgress = $totalDuration > 0 ? number_format((float) ($projectcompleted / $totalDuration) * 100, 2) : 0; // Avoid division by zero
        $actualProgress = number_format((float) $planeProgress, 2); // Ensure actual progress is a float
        $variation = number_format((float) $planeProgress - (float) $actualProgress, 2); // Ensure variation is calculated as float

        return compact(
            'totalDuration',
            'projectcompleted',
            'remaining',
            'planeProgress',
            'actualProgress',
            'variation'
        );
    }
}
// ***********************************************************************************************************

function monthwiseworkProgess($data)
{
    $date = Carbon::parse($data['date']);
    $year = $date->year;
    $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
    $months = [];
    for ($month = 1; $month <= 12; $month++) {
        $months[] = Carbon::createFromDate($year, $month, 1)->format('M');
    }
    $fetchDpr = Dpr::with('users', 'material', 'activities')
        ->where('company_id', $authCompany)
        ->where('projects_id', $data['project'])
        ->whereYear('date', $year)
        ->get();
    $monthlyData = $fetchDpr->groupBy(function ($entry) {
        return Carbon::parse($entry->date)->format('M');
    })->map(function ($entries) {
        return $entries->count();
    });
    $labels = $monthlyData->keys();
    $data = $monthlyData->values();
    $actualProgress = [];
    $plannedProgress = [];
    foreach ($labels as $month) {
        $totalDaysInMonth = Carbon::createFromFormat('M', $month)->daysInMonth;
        $actualProgress[] = number_format((($monthlyData[$month] / $totalDaysInMonth) * 100), 2);
        $plannedProgress[] = number_format(((1 / $totalDaysInMonth) * 100), 2); // Assuming planned progress is evenly distributed
    }
    $chartData = [
        'labels' => $months,
        'datasets' => [
            [
                'label' => 'Actual Progress',
                'data' => $actualProgress,
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1
            ],
            [
                'label' => 'Planned Progress',
                'data' => $plannedProgress,
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'borderWidth' => 1
            ]
        ]
    ];
    // dd($chartData);
    return compact('months', 'labels', 'data', 'actualProgress', 'plannedProgress', 'chartData');
}
// ***********************************************************************************************************
function labourStrength($data)
{
    // dd($data);
    $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
    $fetchData = LabourHistory::select('vendors_id', DB::raw('SUM(qty) as labour_total'), DB::raw('COUNT(*) as labour_count'))
        // $fetchData = LabourHistory::select('vendors_id', DB::raw('COUNT(*) as labour_count'))
        ->where('company_id', $authCompany)
        ->whereNotNull('vendors_id')
        ->whereHas('dpr', function ($query) use ($data) {
            $query->where('projects_id', $data['project']);
        })
        ->groupBy('vendors_id')
        ->with('vendors', 'labours')
        ->get();

    // $fetchData = LabourHistory::select('vendors_id', DB::raw('COUNT(*) as labour_count'))
    //     ->where('company_id', $authCompany)
    //     ->whereNotNull('vendors_id')
    //     ->whereHas('dpr', function ($query) use ($data) {
    //         $query->where('projects_id', $data['project']);
    //     })
    //     ->groupBy('vendors_id')
    //     ->with('vendors', 'labours')
    //     ->get();

    $totalLabourCount = $fetchData->sum('labour_count');
    $totalLabourTotal = $fetchData->sum('labour_total');
    $vendorWiseLabourListing = $fetchData->map(function ($item) {
        return [
            'vendor' => $item->vendors,
            'labour_count' => $item->labour_count,
            'labour_total' => $item->labour_total
        ];
    });
    return compact(
        'totalLabourCount',
        'totalLabourTotal',
        'vendorWiseLabourListing'
    );
}
// ***********************************************************************************************************
if (!function_exists('dilyprogessreport')) {
    function dilyprogessreport($data)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $fetchDpr = Dpr::with('users', 'historie', 'safetie')->where(['projects_id' => $data['project'], 'date' => $data['date']])->where('company_id', $authCompany)->get();
        $users = collect($fetchDpr)->map(function ($entry) {
            return $entry['users']; // Assuming 'users' is the key for user data
        });
        // dd($fetchDpr);
        return compact('users', 'fetchDpr');
    }
}
// ***********************************************************************************************************
if (!function_exists('inventorysdata')) {
    function inventorysdata($data)
    {
        // $fetchPendingApprovals=
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $fetchData = MaterialRequestDetails::with('materialrequests')->where('company_id', $authCompany)
            ->whereHas('materialrequests', function ($qu) use ($data, $authCompany) {
                $qu->where(['projects_id' => $data->project, 'date' => $data->date, 'company_id' => $authCompany]);
            })
            ->get();

        $fetchGoodsReceipt = InwardGoodsDetails::with('InvInwardGood')->where('company_id', $authCompany)
            ->whereHas('InvInwardGood', function ($q) use ($data, $authCompany) {
                $q->with('InvInward');
                $q->whereHas('InvInward', function ($qu) use ($data, $authCompany) {
                    $qu->where(['projects_id' => $data->project, 'date' => $data->date, 'company_id' => $authCompany]);
                });
            })
            ->get();

        $fetchIssueOutward = InvIssuesDetails::with('InvIssueGood')->where('company_id', $authCompany)
            ->whereHas('InvIssueGood', function ($q) use ($data, $authCompany) {
                $q->with('InvIssue');
                $q->whereHas('InvIssue', function ($qu) use ($data, $authCompany) {
                    $qu->where(['projects_id' => $data->project, 'date' => $data->date, 'company_id' => $authCompany]);
                });
            })
            ->get();

        $fetchMaterialReturn = InvReturnsDetails::with('invReturnGood')->where('company_id', $authCompany)
            ->whereHas('invReturnGood', function ($q) use ($data, $authCompany) {
                $q->with('invReturn');
                $q->whereHas('invReturn', function ($qu) use ($data, $authCompany) {
                    $qu->where(['projects_id' => $data->project, 'date' => $data->date, 'company_id' => $authCompany]);
                });
            })
            ->get();
        $fetchPORaised = InwardGoodsDetails::with('InvInwardGood')->where('company_id', $authCompany)
            ->whereHas('InvInwardGood', function ($q) use ($data, $authCompany) {
                $q->with('InvInward');
                $q->whereHas('invInwardEntryTypes', function ($invlist) {
                    $invlist->where('slug', 'from-po');
                });
                $q->whereHas('InvInward', function ($qu) use ($data, $authCompany) {
                    $qu->where(['projects_id' => $data->project, 'date' => $data->date, 'company_id' => $authCompany]);
                });
            })
            ->get();


        $purchaseRequests = $fetchData->groupBy('material_requests_id')->count();
        // $purchaseRequests = $fetchData->count();
        $goodsReceipt = $fetchGoodsReceipt->groupBy('inward_goods_id')->count('recipt_qty');
        $issueOutward = $fetchIssueOutward->groupBy('inv_issue_goods_id')->count('issue_qty');
        $materialReturn = $fetchMaterialReturn->groupBy('inv_return_goods_id')->count('return_qty');
        $pORaised = $fetchPORaised->groupBy('material_requests_id')->count();
        log_daily('Inventory', ' utilites Data Fetched', 'inventorysdata', 'info', json_encode([
            'purchaseRequests' => $purchaseRequests,
            'goodsReceipt' => $goodsReceipt,
            'issueOutward' => $issueOutward,
            'materialReturn' => $materialReturn,
            'pORaised' => $pORaised
        ]));
        return compact('purchaseRequests', 'goodsReceipt', 'issueOutward', 'materialReturn', 'pORaised');
    }
}
// ***********************************************************************************************************
// if (!function_exists('activitesStocksDetails')) {
//     function activitesStocksDetails($data)
//     {
//         // dd($data);
//         $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;

//         // $type = 'materials';
//         // if ($data['filterName'] == 'machine' || $data['filterName'] == 'machines' ) {
//         //     $type = 'machines';
//         // } else {
//         //     $type = 'materials';
//         // }

//         // $fetchInventory = Inventory::with('materials.units', 'assets.units')->where('company_id', $authCompany)->where('projects_id', $data['project'])->where('type', $type);
//         // if ($data['store']) {
//         //     $fetchInventory = $fetchInventory->whereHas('inventoryStore', function ($query) use ($data) {
//         //         $query->where('store_warehouses_id', $data['store']);
//         //     });
//         // }

//         // Fetch inventory with related materials and assets
//         // Fetch inventory query with necessary relationships and filters
//         $type = ($data['filterName'] === 'machine' || $data['filterName'] === 'machines') ? 'machines' : 'materials';
//         $fetchInventoryQuery = InventoryLog::with('materials.units', 'assets.units')
//             ->where('company_id', $authCompany)
//             ->where('projects_id', $data['project'])
//             ->where('type', $type)
//             ->where('store_warehouses_id', $data['store']);

//         // Clone the query for fallback use
//         $fetchInventoryClone = clone $fetchInventoryQuery;

//         // Apply date filter and fetch results
//         $fetchInventoryWithDate = $fetchInventoryQuery->where('date', $data['date'])->get();

//         // Check if results for the specified date are empty
//         if ($fetchInventoryWithDate->isEmpty()) {
//             // If no results for the date, return the full inventory ordered by ID
//             return $fetchInventoryClone->orderBy('id', 'desc')->get();
//         }
//         // Return the filtered results
//         return $fetchInventoryWithDate;
//     }
// }

if (!function_exists('activitesStocksDetails')) {
    function activitesStocksDetails($data)
    {
        // Safely get authenticated company ID
        $authCompany = Auth::guard('company')->user()?->company_id
            ?? Auth::guard('company-api')->user()?->company_id;

        if (!$authCompany) {
            return collect(); // or throw exception
        }

        // Validate required inputs
        if (!isset($data['project'], $data['store'], $data['date'])) {
            return collect();
        }

        // Normalize type
        $type = in_array($data['filterName'], ['machine', 'machines']) ? 'machines' : 'materials';

        // Base query
        $baseQuery = InventoryLog::where('company_id', $authCompany)
            ->where('projects_id', $data['project'])
            ->where('store_warehouses_id', $data['store'])
            ->where('type', $type);

        // Load only needed relationships
        if ($type === 'materials') {
            $baseQuery->with('materials.units');
        } else {
            $baseQuery->with('assets.units');
        }

        // Try to get records for the exact date
        $results = $baseQuery->where('date', $data['date'])->get();

        // If found, return them
        if ($results->isNotEmpty()) {
            return $results;
        }

        // Otherwise, get the **most recent log** before or on that date
        $latest = $baseQuery->clone()
            ->where('date', '<=', $data['date'])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        // Return as collection (to match expected structure)
        return $latest ? collect([$latest]) : collect();
    }
}
// *********************************dpr project finder*********************************************
if (!function_exists('dprprojectfinder')) {
    function dprprojectfinder($project, $subproject, $date,)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $fetchActivites = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')
            ->where('projects_id', $project)
            ->where('sub_projects_id', $subproject)
            ->where('date', $date)
            ->where('company_id', $authCompany)

            ->first();
        return $fetchActivites;
    }
}
// *********************************dpr project finder*********************************************
// ***********************************************************************************************************
if (!function_exists('issueTypeList')) {
    function issueTypeList($typeId)
    {
        // $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $data = InvIssueList::all();
        foreach ($data as $key => $val) {
            if ($typeId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('getPrList')) {
    function getPrList($typeId)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $data = MaterialRequest::orderBy('id', 'desc')->where('status', 0)->where('company_id', $authCompany)->get();
        foreach ($data as $key => $val) {
            if ($val->request_id !== null) {
                if ($typeId == $val->id) {
                    echo "<option value='" . $val->id . "' selected>" . $val->request_id . ' --- ' . $val->date . "</option>";
                } else {
                    echo "<option value='" . $val->id . "' >" . $val->request_id . ' --- ' . $val->date . "</option>";
                }
            }
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('invInwardEntryType')) {
    function invInwardEntryType($typeId)
    {
        $data = InvInwardEntryType::all();
        foreach ($data as $key => $val) {
            if ($typeId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}

// ***********************************************************************************************************
if (!function_exists('vendorList')) {
    function vendorList($typeId)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $data = Vendor::where('company_id', $authCompany)->get();
        foreach ($data as $key => $val) {
            if ($typeId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
if (!function_exists('vendorSupplerList')) {
    function vendorSupplerList($typeId)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $data = Vendor::whereIn('type', ['supplier', 'both'])->where('company_id', $authCompany)->get();
        foreach ($data as $key => $val) {
            if ($typeId == $val->id) {
                echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
            } else {
                echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
            }
        }
    }
}
// ***********************************************************************************************************
// if (!function_exists('prList')) {
//     function prList($data)
//     {
//         $fetchPrList=MaterialRequest::where('')->get();
//     }
// }
// ***********************************************************************************************************
if (!function_exists('issueTagFinder')) {
    function issueTagFinder($typess, $invIdsss)
    {
        // dd($typess, $invIdsss);
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        // $type = $invIdsss;
        // if ($invIdsss != null) {
        $invId = (int) $typess; //tag id
        $type = InvIssueList::select('slug')->where('id', $invIdsss)->first();
        // dd($type, $invId);
        $responsesss = [];
        if (isset($type)) {
            switch ($type->slug) {
                case 'staff':
                    $data = CompanyUser::where('company_id', $authCompany)->where('id', $invId)->first();
                    $responsesss = new CompanyResource($data);
                    $message = 'Staff Fetch Successfull';
                    break;
                case 'contractor':
                    $data = Vendor::where('company_id', $authCompany)->where('id', $invId)->first();
                    // dd($data );
                    $responsesss = new VendorResource($data);
                    $message = 'Vendor Fetch Successfull';
                    break;
                case 'machines-or-other-assets':
                    $data = Assets::where('company_id', $authCompany)->where('id', $invId)->first();
                    $responsesss = new AssetsResource($data);
                    $message = 'Assets Fetch Successfull';
                    break;
                case 'other-project':
                    $data = Project::where('company_id', $authCompany)->where('id', $invId)->first();
                    $responsesss = new ProjectResource($data);
                    // $responsesss = new InvProjectListResources($data);
                    $message = 'Project Fetch Successfull';
                    break;
                case 'same-project-other-stores':
                    $data = StoreWarehouse::where('company_id', $authCompany)->where('id', $invId)->first();
                    $responsesss = new StoreResources($data);
                    $message = 'Store/Warehouse Fetch Successfull';
                    break;
                default:
                    $data = '';
                    $responsesss = '';
                    $message = 'Store/Warehouse Fetch Successfull';
            }
            // dd($responsesss);
            if ($data) {
                return $responsesss;
            } else {
                return null;
            }
        } else {
            return '';
        }
    }
}
// ***********************************************************************************************************
if (!function_exists('findInvIssueList')) {
    function findInvIssueList($invIdsss)
    {
        return InvIssueList::where('id', $invIdsss)->first();
    }
}
// ***********************************************************************************************************
// *************************************************************************************************
if (!function_exists('findEntryType')) {
    function findEntryType($type, $id)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $type = $type;
        $data = "";
        switch ($type) {
            case 'direct':
                // dd($type, $id);
                $fetchdata = Vendor::where('id', $id)->where('company_id', $authCompany)->where('type', 'supplier')->latest()->first();
                $data = new VendorResource($fetchdata);
                // dd($data);
                $message = 'Vendor Fetch Successfull';
                break;
            case 'from-po':
                $fetchdata = Vendor::where('id', $id)->where('company_id', $authCompany)->where('type', 'supplier')->orderBy('id', 'desc')->first();
                $data = new VendorResource($fetchdata);
                $message = 'Vendor Fetch Successfull';
                break;
            case 'from-pr':
                $fetchdata = Vendor::where('id', $id)->where('company_id', $authCompany)->where('type', 'supplier')->orderBy('id', 'desc')->first();
                $data = new VendorResource($fetchdata);
                $message = 'Vendor Fetch Successfull';
                break;
            case 'from-other-project':
                $fetchdata = Project::where('id', $id)->where('company_id', $authCompany)->orderBy('id', 'desc')->first();
                $data = new InvProjectListResources($fetchdata);
                $message = 'Project Fetch Successfull';
                break;
            case 'same-project-other-stores':
                $fetchdata = StoreWarehouse::where('id', $id)->where('company_id', $authCompany)->orderBy('id', 'desc')->first();
                // dd($data);
                $data = new StoreResources($fetchdata);
                $message = 'Store/Warehouse Fetch Successfull';
                break;
            case 'from-client':
                $fetchdata = Vendor::where('id', $id)->where('company_id', $authCompany)->where('type', 'supplier')->orderBy('id', 'desc')->first();
                $data = new VendorResource($fetchdata);
                $message = 'Vendor Fetch Successfull';
                break;
            case 'cash-purchase':
                $fetchdata = Vendor::where('id', $id)->where('company_id', $authCompany)->where('type', 'supplier')->orderBy('id', 'desc')->first();
                $data = new VendorResource($fetchdata);
                $message = 'Vendor Fetch Successfull';
                break;
            default:
                return [];
        }
        // dd($data);
        if ($data) {
            // dd($data);
            return $data;
        } else {
            return [];
        }
    }
}

// *******************************************************************************************************
if (!function_exists('findInvEntryTypeList')) {
    function findInvEntryTypeList($invId)
    {
        return InvInwardEntryType::where('id', $invId)->first();
    }
}
// ***********************************Estimated Cost for Project**************************************************************
if (!function_exists('estimatedcost')) {
    function estimatedcost($data)
    {
        // dd($data);
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $fetchData = Activities::select('id', 'qty', 'rate', 'amount', 'project_id')
            ->where(function ($query) {
                $query->whereNotNull('qty')
                    ->orWhereNotNull('rate')
                    ->orWhereNotNull('amount');
            })
            ->where('company_id', $authCompany)
            ->where('project_id', $data['project'])
            ->whereNull('deleted_at')
            ->get();

        $totalAmount = $fetchData->sum(function ($item) {
            return isset($item->amount) ? (float) $item->amount : 0;
        });

        // $dprwiseactiviteshistory=dprwiseactiviteshistory($fetchData);
        // dd($fetchData->toArray(),$totalAmount);

        log_daily('Inventory', 'Estimated Cost for Project', 'estimatedcost', 'info', json_encode([
            'project_id' => $data['project'],
            'total_amount' => $totalAmount,
            'activities_count' => $fetchData->count(),
        ]));
        return $totalAmount;
    }
}
// *************************************************************************************************
if (!function_exists('estimatedcostforexecutedqty')) {
    function estimatedcostforexecutedqty($data, $pid)
    {
        // dd($data);
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $totalAmount = 0;
        $fetchData = ActivityHistory::select('activity_histories.id', 'activity_histories.qty', 'activities.rate')
            ->join('activities', 'activity_histories.activities_id', '=', 'activities.id')
            ->whereNotNull('activity_histories.qty')
            ->where('activity_histories.company_id', $authCompany)
            ->whereHas('dpr', function ($query) use ($pid) {
                $query->where('projects_id', $pid['project']);
                // $query->where('date', '2024-04-26');
                if ($pid['subproject'] != null) {
                    $query->where('sub_projects_id', $pid['subproject']);
                }
            })
            ->get();
        $fetchData = collect($fetchData);
        $totalQtySum = $fetchData->sum(function ($item) {
            return $item->qty * $item->rate;
        });
        log_daily('Inventory', 'Utilites Estimated Cost for estimatedcostforexecutedqty', 'estimatedcostforexecutedqty', 'info', json_encode($totalQtySum));
        return $totalQtySum;
    }
}
// *************************************************************************************************
if (!function_exists('filterusernametoid')) {
    function filterusernametoid($name)
    {
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $data = CompanyUser::where('name', 'LIKE', '%' . $name . '%')->where('company_id', $authCompany)->first();
        return $data->id;
    }
}
// *************************************************************************************************
if (!function_exists('findVendor')) {
    function findVendor($id)
    {
        // $authCompany = Auth::guard('company')->user()->company_id;
        $data = Vendor::where('id', $id)->first();
        return $data;
    }
}
// *************************************************************************************************
if (!function_exists('findUserDetails')) {
    function findUserDetails($id)
    {
        // $authCompany = Auth::guard('company')->user()->company_id;
        $data = CompanyUser::where('id', $id)->first();
        return $data;
    }
}
// *************************************************************************************************
if (!function_exists('generatePdf')) {
    function generatePdf($view, $data, $filename)
    {
        // dd($view, $data, $filename);
        $pdf = PDF::loadView($view, $data)->setPaper('A4', 'landscape');
        // $pdf = PDF::loadView($view, $data)->setPaper('A4', 'portrait');
        // dd($pdf);
        // return  $pdf;
        $pdf->save(storage_path('app/public/' . $filename));
        return URL::to('/storage/' . $filename);
    }
}
// *********************************AccessToken*************************************************************
function getAccessToken()
{
    $credentialsFilePath = config_path('konsite-firebase-adminsdk.json');
    $client = new \Google_Client();
    $client->setAuthConfig($credentialsFilePath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    $token = $client->fetchAccessTokenWithAssertion();
    $accessToken = $token['access_token'];
    return $accessToken;
}
// *****************************sendNotification****************************************************
// function sendNotification($deviceToken, $title, $body, $data = [])
// {
//     // Generate the Firebase access token
//     $accessToken = getAccessToken();

//     // Ensure $data is an array and add title/body if not present
//     if (!is_array($data)) {
//         $data = [];
//     }
//     $data['title'] = $title;
//     $data['body'] = $body;

//     // Prepare the notification payload
//     $payload = [
//         "message" => [
//             "token" => $deviceToken,
//             "notification" => [
//                 "title" => $title,
//                 "body" => $body,
//             ],
//             "data" => array_map('strval', $data), // FCM data must be string values
//             "android" => [
//                 "priority" => "high"
//             ]
//         ]
//     ];

//     // Convert the payload to JSON format
//     $payloadJson = json_encode($payload);

//     // cURL headers
//     $headers = [
//         'Content-Type: application/json',
//         "Authorization: Bearer {$accessToken}",
//     ];

//     // Initialize cURL
//     $ch = curl_init('https://fcm.googleapis.com/v1/projects/konsite-a66af/messages:send');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     // Execute cURL request
//     $response = curl_exec($ch);

//     // Check for errors
//     if (curl_errno($ch)) {
//         $error = curl_error($ch);
//         Log::error("FCM Send Error: {$error}");
//         return false;
//     }

//     curl_close($ch);

//     // Optionally log the response for debugging
//     Log::info('FCM Response', ['response' => $response]);

//     return $response;
// }


// function sendNotification($notificationData, $fcmTokens)
// {
//     // dd($notificationData, $fcmTokens);
//     $accessToken = getAccessToken();
//     $notification = [
//         'title' => $notificationData->title,
//         'body' => json_encode($notificationData->body),
//     ];
//     $notiFicationdata = [
//         'notificationData' => "test",
//         "data" => json_encode($notificationData->data ?? $notificationData->body)
//     ];
//     $data = [
//         'message' => [
//             'token' => $fcmTokens,
//             'notification' => $notification,
//             'data' => $notiFicationdata,
//         ]
//     ];

//     // dd($data);
//     // cURL headers
//     $headers = [
//         'Content-Type: application/json',
//         'Authorization: Bearer ' . $accessToken, // Replace with your actual Firebase server key
//     ];
//     // Initialize cURL
//     $ch = curl_init('https://fcm.googleapis.com/v1/projects/konsite-a66af/messages:send');
//     // Set cURL options
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     // Execute cURL request
//     $response = curl_exec($ch);
//     // dd($response);
//     // Check for errors
//     if (curl_errno($ch)) {
//         $error = curl_error($ch);
//         // Handle cURL error (e.g., log it)
//         error_log('FCM Send Error: ' . $error);
//         return false;
//     }
//     // Close cURL resource
//     curl_close($ch);
//     return $response;
// }


function sendNotification($notificationData, $fcmTokens)
{
    $accessToken = getAccessToken();
    $notification = [
        'title' => $notificationData->title,
        'body' => $notificationData->body,
    ];
    $notiFicationdata = [
        'notificationData' => "Koncite",
        "data" => json_encode($notificationData->data ?? $notificationData->body)
    ];

    // Prepare the data array
    $data = [
        'message' => [
            'token' => $fcmTokens, // Ensure this is a valid string token
            'notification' => $notification,
            'data' => $notiFicationdata,
        ]
    ];
    // dd($data);
    // cURL headers
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
    ];

    // Initialize cURL
    $ch = curl_init('https://fcm.googleapis.com/v1/projects/konsite-a66af/messages:send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        error_log('FCM Send Error: ' . $error);
        return false;
    }

    // Close cURL resource
    curl_close($ch);
    return $response;
}

// This rewritten code ensures better error handling, logging, and readability while maintaining the original functionality.
// *****************************Notification********************************************************************
if (!function_exists('addNotifaction')) {
    function addNotifaction($msg, $data, $projects_id, $company_id, $reciver_id = null, $details = null)
    {
        $authCompany = Auth::guard('company')->user() ?? Auth::guard('company-api')->user();
        $isCreated = Notifaction::create([
            'user_id' => $authCompany->id ?? null,
            'sender_id' => $reciver_id ?? null,
            'message' => $msg ?? null,
            'details' => json_encode($data) ?? null,
            'remarks' => $details ?? null,
            'project_id' => $projects_id ?? null,
            'company_id' => $authCompany?->company_id ?? null
        ]);

        info($isCreated);
        // info("Notifactionnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn!!!!!!!!!!!!!!!!!!!!!!!!!!!");
        return $isCreated;
    }
}
// *****************************Admin Notification********************************************************************
if (!function_exists('adminNotifaction')) {
    function adminNotifaction($msg, $data, $projects_id, $company_id, $reciver_id = null, $details = null)
    {
        $authCompany = Auth::guard('company')->user() ?? Auth::guard('company-api')->user();
        $isCreated = AdminNotifaction::create([
            'user_id' => $reciver_id ?? null,
            'message' => $msg ?? null,
            'details' => json_encode($data) ?? null,
            'remarks' => $details ?? null,
            'company_id' => $authCompany?->company_id ?? null
        ]);
        return $isCreated;
    }
}

function fetchAdminNotifaction()
{
    $authCompany = auth()->user();
    $notifications = AdminNotifaction::where('user_id', $authCompany->id)
        ->where('status', 0) // Assuming status 0 means unread
        ->orderBy('created_at', 'desc')
        ->get();
    return $notifications;
}
// *************************************************************************************************
function checkAdminPermissions($menuName, $roleId, $userId, $action, $redirectionMode = false)
{
    log_daily('Admin', 'checkAdminPermissions', 'checkAdminPermissions', 'info', json_encode([
        'menuName' => $menuName,
        'roleId' => $roleId,
        'userId' => $userId,
        'action' => $action,
        'redirectionMode' => $redirectionMode
    ]));
    if ($roleId == 1):
        return true;
    else:
        $menuId = AdminMenu::where('slug', $menuName)->pluck('id')->first();
        if (!empty($menuId)):
            $permissionDetails = AdminUserPermission::where('user_id', $userId)->where('menu_id', $menuId)->where('action', $action)->first();
            // $permissionDetails = AdminUserPermission::where('user_id', $userId)->where('menu_id', $menuId)->where('action', $action)->first();
            if (empty($permissionDetails)):
                if ($redirectionMode):
                    abort(403);
                else:
                    return false;
                endif;
            else:
                return true;
            endif;
        else:
            return false;
        endif;
    endif;
}
// *************************************************************************************************
function checkCompanyPermissions($menuName, $roleId, $userId, $action, $redirectionMode = false)
{
    log_daily('Admin', 'checkCompanyPermissions', 'checkCompanyPermissions', 'info', json_encode([
        'menuName' => $menuName,
        'roleId' => $roleId,
        'userId' => $userId,
        'action' => $action,
        'redirectionMode' => $redirectionMode
    ]));
    // dd($menuName, $roleId, $userId, $action, $redirectionMode = false);
    $companyId = searchCompanyId($userId);
    $roleSlug = Company_role::where('id', $roleId)->where('company_id', $companyId)->first();
    // dd($roleSlug);
    if ($roleSlug && $roleSlug->slug == 'super-admin') {
        // if ($roleId == $roleId && $roleSlug->slug == 'super-admin') {
        return true; // User with role 10 has full access
    } else {
        $menuId = Company_permission::where('slug', $menuName)->pluck('id')->first();
        // dd($menuId);
        if (!empty($menuId)) {
            $rolePermissionDetails = Company_role_permission::where('company_role_id', $roleId)
                ->where('company_permission_id', $menuId)
                ->where('action', $action)
                ->first();

            $permissionDetails = Company_user_permission::where('company_user_id', $userId)
                ->where('company_permission_id', $menuId)
                ->where('action', $action)
                ->first();

            if (empty($rolePermissionDetails)) {
                if (empty($permissionDetails)) {
                    if ($redirectionMode) {
                        abort(403); // No permission, abort with 403
                    } else {
                        return false; // No permission
                    }
                } else {
                    return true; // User has a permission entry
                }
            } else {
                return true; // Role has a permission entry
            }
        } else {
            return false; // Menu not found
        }
    }
}
// *************************************************************************************************
// if (!function_exists('generatePdf')) {
//     function generatePdf($type, $exportName, $title)
//     {
//         if ($type == 'xlsx') {
//             $fileExt = 'xlsx';
//             $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
//         } elseif ($type == 'csv') {
//             $fileExt = 'csv';
//             $exportFormat = \Maatwebsite\Excel\Excel::CSV;
//         } elseif ($type == 'xls') {
//             $fileExt = 'xls';
//             $exportFormat = \Maatwebsite\Excel\Excel::XLS;
//         } else {
//             $fileExt = 'xlsx';
//             $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
//         }
//         $filename = $title . date('d-m-Y') . "." . $fileExt;
//         return Excel::download(new $exportName, $filename, $exportFormat);
//     }
// }
// *************************************************************************************************
if (!function_exists('totalActivitiesUsage')) {
    function totalActivitiesUsage($getActivites)
    {
        $data = [];
        $authCompany = Auth::guard('company-api')->user()->company_id ?? Auth::guard('company')->user()->company_id;
        $activitiesId = $getActivites;
        // Fetch all activities history for the given activities ID and company ID
        $activitiesHistory = ActivityHistory::where('activities_id', $activitiesId)
            ->where('company_id', $authCompany)
            ->get();
        // Calculate the total quantity used
        $totalQtyUsed = $activitiesHistory->sum('qty');
        // Fetch the activity to get the original quantity
        $activity = Activities::where('id', $activitiesId)
            ->where('company_id', $authCompany)
            ->first();
        if (!$activity) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => 'Activity not found',
                'response' => [],
            ]);
        }
        // Compare the total quantity used with the original quantity
        $originalQty = $activity->qty;
        // dd( $originalQty,$totalQtyUsed);
        $remainingQty = ($originalQty != 0 && $totalQtyUsed != 0) ? ($originalQty - $totalQtyUsed) : 0.00;
        // Calculate the percentage of quantity used
        $percentageUsed = ($totalQtyUsed != 0 && $originalQty != 0) ? (($totalQtyUsed / $originalQty) * 100) : 0.00;
        // Calculate the percentage of remaining quantity
        $percentageRemaining = ($remainingQty != 0 && $originalQty != 0) ? (($remainingQty / $originalQty) * 100) : 0.00;
        // Format the percentage values to two decimal places
        $data['originalQty'] = $originalQty;
        $data['totalQtyUsed'] = $totalQtyUsed;
        $data['remainingQty'] = $remainingQty;
        $data['percentageUsed'] = number_format($percentageUsed, 2);
        $data['percentageRemaining'] = number_format($percentageRemaining, 2);
        return $data;
    }
}
// *************************************************************************************************
function getAccessTokens()
{
    // Path to your Firebase credentials JSON file
    $credentialsFilePath = config_path('konsite-firebase-adminsdk.json');
    // Create a new Google client
    $client = new Google_Client();
    // Load the credentials from the Firebase JSON file
    $client->setAuthConfig($credentialsFilePath);
    // Add Firestore and Firebase Messaging scopes
    $client->addScope('https://www.googleapis.com/auth/datastore'); // Firestore scope
    // $client->addScope('https://www.googleapis.com/auth/firebase.messaging'); // FCM scope
    // Fetch the access token
    $token = $client->fetchAccessTokenWithAssertion();
    // Return the access token
    return $token['access_token'];
}
// Function to get data from Firestore
function getFirestoreData($roomId)
{
    // dd($roomId);
    // $roomId = 121;
    // Firestore URL for the specific collection or document
    $url = 'https://firestore.googleapis.com/v1/projects/konsite-a66af/databases/(default)/documents/chats/' . $roomId . '/message';
    // Get the access token by calling the getAccessToken() method
    $token = getAccessTokens();
    // dd($token);
    // Initialize a cURL session
    $ch = curl_init();
    // Set the URL for the cURL request
    curl_setopt($ch, CURLOPT_URL, $url);
    // Return the transfer as a string instead of outputting it directly
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Set the HTTP headers, including the access token for authorization
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token,
    ]);
    // Execute the cURL request and get the response
    $response = curl_exec($ch);
    // Close the cURL session
    curl_close($ch);
    // Decode the JSON response into an associative array
    $data = json_decode($response, true);
    // Return the data
    return $data;
}

if (!function_exists('findInvIssueList')) {
    function findInvIssueList($invIdsss)
    {
        return InvIssueList::where('id', $invIdsss)->first();
    }
}

if (!function_exists('findVendor')) {
    function findVendor($id)
    {
        // $authCompany = Auth::guard('company')->user()->company_id;
        $data = Vendor::where('id', $id)->first();
        return $data;
    }
}
/**
 * Initialize Cloud Firestore with default project ID.
 */

function setup_client_create(string $projectId = null)
{
    // // Create the Cloud Firestore client
    // if (empty($projectId)) {
    //     // The `projectId` parameter is optional and represents which project the
    //     // client will act on behalf of. If not supplied, the client falls back to
    //     // the default project inferred from the environment.
    //     printf('Created Cloud Firestore client with default project ID.' . PHP_EOL);
    // } else {
    //     $db = new FirestoreClient([
    //         'projectId' => $projectId,
    //     ]);
    //     printf('Created Cloud Firestore client with project ID: %s' . PHP_EOL, $projectId);
    // }
    // $db = new FirestoreClient();
    // $usersRef = $db->collection('chats');
    // $snapshot = $usersRef->documents();
    // return $snapshot;
}

// **************************Dome Data**********************************************************
if (!function_exists('domeData')) {
    function domeData($companyid)
    {
        $planned_start_date = Carbon::now()->format('Y-m-d');
        $planned_end_date = Carbon::now()->addYear()->format('Y-m-d');

        // Companies
        $company = Companies::create([
            'registration_name' => 'Demo Company',
            'company_registration_no' => 'demo@koncite.com',
            'registered_address' => '1234567890',
            'logo' => 'dome.png',
            'company_id' => $companyid, // Removed extra space in key
        ]);

        // Project
        $project = Project::create([
            'project_name' => 'Demo Project',
            'companies_id' => $company->id ?? null, // Removed null coalescing operator
            'company_id' => $companyid,
            'address' => 'Delhi, India', // Fixed spacing in address
            'planned_start_date' => $planned_start_date,
            'planned_end_date' => $planned_end_date,
        ]);

        // Store & Warehouse
        StoreWarehouse::create([
            'name' => 'Main Store',
            'location' => null, // Changed Null to null
            'projects_id' => $project->id,
            'company_id' => $companyid,
        ]);

        // Vendor
        $json = file_get_contents(database_path() . '/demodata/vendors.json');
        $data = json_decode($json);
        foreach ($data->vendor as $value) { // Removed unnecessary $key variable
            Vendor::updateOrCreate([
                'company_id' => $companyid,
                'name' => $value->name,
                'email' => $value->email,
                'phone' => $value->phone,
                'address' => $value->address,
                'type' => $value->type,
                'contact_person_name' => $value->contact_person_name,
            ]);
        }

        // Units
        $json = file_get_contents(database_path() . '/demodata/units.json');
        $data = json_decode($json);
        foreach ($data->unit as $value) { // Removed unnecessary $key variable
            Unit::updateOrCreate([
                'company_id' => $companyid,
                'unit' => $value->name,
            ]);
        }

        // Labour
        $findUnit = Unit::where(['unit' => 'Nos', 'company_id' => $companyid])->first();
        $json = file_get_contents(database_path() . '/demodata/labours.json');
        $data = json_decode($json);
        foreach ($data->labour as $value) { // Removed unnecessary $key variable
            Labour::updateOrCreate([
                'company_id' => $companyid,
                'name' => $value->name,
                'category' => $value->category,
                'unit_id' => $findUnit->id
            ]);
        }

        // Activities
        $json = file_get_contents(database_path() . '/demodata/activites.json');
        $data = json_decode($json);
        $parentId = null; // Initialize parentId as null for clarity
        foreach ($data->activite as $activity) {
            $unitId = $activity->unit === "NULL" ? null : unitnametoid($activity->unit, $companyid);
            $parentId = Activities::updateOrCreate([
                'company_id' => $companyid, // Changed hardcoded value to $companyid
                'type' => $activity->type,
                'unit_id' => $unitId,
                'activities' => $activity->name,
                'parent_id' => null,
                'project_id' => $project->id
            ]);

            if (!empty($activity->children) && is_array($activity->children)) {
                foreach ($activity->children as $activityChild) {
                    $unitId = $activityChild->unit === "NULL" ? null : unitnametoid($activityChild->unit, $companyid);
                    Activities::updateOrCreate([
                        'company_id' => $companyid, // Changed hardcoded value to $companyid
                        'type' => $activityChild->type,
                        'unit_id' => $unitId,
                        'activities' => $activityChild->name,
                        'parent_id' => $parentId->id,
                        'project_id' => $project->id,
                    ]);
                }
            }
        }

        // Assets
        $json = file_get_contents(database_path() . '/demodata/assets.json');
        $data = json_decode($json);
        foreach ($data->assets as $asset) {
            Assets::updateOrCreate([
                'company_id' => $companyid,
                'name' => $asset?->name ?? "",
                'specification' => $asset?->specification ?? "",
                'unit_id' => $asset?->unit === "NULL" ? null : unitnametoid($asset?->unit, $companyid)
            ]);
        }

        // Materials
        $json = @file_get_contents(database_path() . '/demodata/material.json');
        $data = json_decode($json);
        foreach ($data->materials as $asset) {
            Materials::updateOrCreate([
                'company_id' => $companyid,
                'name' => $asset->name,
                'specification' => $asset->specification,
                'unit_id' => $asset->unit === "NULL" ? null : unitnametoid($asset->unit, $companyid),
                'class' => $asset->class
            ]);
        }
    }
    // **************************End Dome Data**********************************************************
}

function isActiveRoute($routes, $class = 'active')
{
    if (is_array($routes)) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routes)) {
        return $class;
    }

    return '';
}
if (!function_exists('prManagmentUpdateStatus')) {
    function prManagmentUpdateStatus($id, $status)
    {
        log_daily('MaterialRequest', 'prManagmentUpdateStatus', 'prManagmentUpdateStatus', 'info', json_encode([
            'material_request_id' => $id,
            'status' => $status
        ]));
        // Update the status for all PrMemberManagment records with the given material_request_id
        $updatedRows = PrMemberManagment::where('material_request_id', $id)->update(['is_active' => $status]);
        // Check if any records were updated
        if ($updatedRows > 0) {
            // Retrieve the updated records
            return PrMemberManagment::where('material_request_id', $id)->get();
        } else {
            // Return null if no records were found or updated
            return null;
        }
    }
}

function excelDateToDate($excelDate)
{
    // Excel's base date is January 1, 1900
    $baseDate = strtotime('1900-01-01');

    // Excel date is the number of days since the base date
    // We need to subtract 1 because Excel considers 1 as the first day
    $timestamp = $baseDate + ($excelDate - 1) * 86400; // 86400 seconds in a day

    // Create a DateTime object
    $date = new DateTime();
    $date->setTimestamp($timestamp);

    // Return the formatted date
    return $date->format('Y-m-d'); // Change format as needed
}

if (!function_exists('prList')) {
    function prList($data)
    {
        $authCompany = Auth::guard('company')->user() ?? Auth::guard('company-api')->user();
        $user_id = $authCompany->id;
        $fetchPrList = [];
        if ($authCompany->companyUserRole->slug == 'super-admin') {
            $fetchPrList = MaterialRequest::where('company_id', $authCompany->company_id)
                ->whereHas('materialRequest', function ($q) {
                    $q->whereNotNull('material_requests_id'); // checking that material_requests_id exists (is not null)
                })
                ->where('status', 0)
                ->get(); // 1:approved,3:allocation
            //    dd($fetchPrList);
        } else {
            $fetchPrListMaem = PrMemberManagment::where('company_id', $authCompany->company_id)->where('user_id', $user_id)->where('is_active', 0)->get();
            foreach ($fetchPrListMaem as $key => $value) {
                $levelCheck = (int) $value?->leavel - 1;
                if ($levelCheck !== 0) {
                    $findPrApprovalPreviousLevel = findprApprovalLevelMemebr($value?->material_request_id, $value?->project_id, $authCompany?->company_id, $levelCheck);
                    if (isset($findPrApprovalPreviousLevel)) {
                        $fetchPrList[] = MaterialRequest::where('company_id', $authCompany->company_id)->where('id', $value?->material_request_id)
                            ->whereHas('materialRequest', function ($q) {
                                $q->whereNotNull('material_requests_id'); // checking that material_requests_id exists (is not null)
                            })
                            ->where('status', 0)
                            ->first();
                        // dd( $fetchPrList);
                    }
                }
            }
        }
        log_daily('MaterialRequest', 'prList', 'prList', 'info', json_encode([
            'company_id' => $authCompany->company_id,
            'user_id' => $user_id,
            'fetchPrList' => $fetchPrList
        ]));
        return $fetchPrList;
    }
}

function findprApprovalLevelMemebr($mr, $p, $c, $l)
{
    log_daily('MaterialRequest', 'prManagmentUpdateStatus', 'prManagmentUpdateStatus', 'info', json_encode([$mr, $p, $c, $l]));
    $fetchPrList = PrMemberManagment::where('company_id', $c)
        ->where('material_request_id', $mr)
        ->where('leavel', $l)
        ->where('project_id', $p)
        ->where('is_active', 1)->exists();;
    return $fetchPrList;
}

if (!function_exists('sendEmail')) {
    function sendEmail($to, $subject, $template, $data)
    {
        log_daily('Email', 'sendEmail', 'sendEmail', 'info', json_encode([
            'to' => $to,
            'subject' => $subject,
            'template' => $template,
            'data' => $data
        ]));
        $to = $to;
        $subject = $subject;
        $template = $template;
        $data = $data;
        Mail::to($to)->send(new TestMail($data, $subject, $template));
    }
}

if (!function_exists('inventoryLog')) {
    function inventoryLog($data, $msg, $invId, $storeWarehousesId, $quantity, $inventory_type)
    {
        log_daily('Inventory', 'Inventory Log Created Utilites', 'inventoryLog', 'info', json_encode([
            'data' => $data,
            'message' => $msg,
            'invId' => $invId,
            'storeWarehousesId' => $storeWarehousesId,
        ]));
        foreach ($storeWarehousesId as $key => $vlu) {
            $inventoryData = [
                'projects_id' => $data?->projects_id ?? null,
                'store_warehouses_id' => $storeWarehousesId[$key]?->id ?? null,
                'materials_id' => $data?->type == 'materials' ? $data?->materials_id : null, // Change '' to null
                'assets_id' => $data?->type == 'machines' ? $data?->assets_id : null, // Change '' to null
                'user_id' => $data?->user_id,
                'date' => Carbon::now(),
                'type' => $data?->type,
                'recipt_qty' => $data?->recipt_qty ?? 0,
                'reject_qty' => $data?->reject_qty ?? 0,
                'total_qty' => $data?->total_qty,
                'po_qty' => $data?->po_qty ?? null,
                'qty' => $quantity ?? null,
                'price' => $data?->price ?? 0,
                'remarks' => $data?->remarks ?? '',
                'company_id' => $data?->company_id,
                'message' => $msg ?? '',
                'inventory_id' => $invId ?? '',
                'inventory_type' => $inventory_type ?? '',
            ];
            $sdfghjkl = InventoryLog::create($inventoryData);
        }
    }
}

if (!function_exists('notifyprlist')) {
    function notifyprlist()
    {
        // $authCompany = Auth::guard('company')->user() ?? Auth::guard('company-api')->user();
        // $data = MaterialRequest::with('materialRequest', 'materialRequestDetails')->where('company_id', $authCompany->company_id)->where('status', 0)->orderBy('id', 'desc')->get();
        // return $data;

        return prList('');
    }
}

if (!function_exists('alertnotifylist')) {
    function alertnotifylist()
    {
        $authCompany = Auth::guard('company')->user() ?? Auth::guard('company-api')->user();
        $data = Notifaction::where('user_id', $authCompany->id)->where('company_id', $authCompany->company_id)->orderBy('created_at', 'desc')->get();
        // $result=$data?NotifactionResource::collection($data):[];
        // // dd($result);
        return $data;
    }
}

function formatAmount($amount, $digit = 2)
{
    return number_format($amount, $digit);
}

function checkPrApprovalMemebr($projectd)
{
    $authCompany = Auth::guard('company')->user() ?? Auth::guard('company-api')->user();
    $findpam = PrApprovalMember::where('project_id', $projectd->projects_id)->where('company_id', $authCompany->company_id)->get();
    $status = $findpam->isEmpty() ? 1 : 0;
    return $status;
}
function ckeckPrApprovandmemberAllocation($projects_id, $material_requests_id)
{
    log_daily('MaterialRequest', 'ckeckPrApprovandmemberAllocation', 'ckeckPrApprovandmemberAllocation', 'info', json_encode([
        'projects_id' => $projects_id,
        'material_requests_id' => $material_requests_id
    ]));
    $authCompany = Auth::guard('company')->user() ?? Auth::guard('company-api')->user();
    $findpam = PrApprovalMember::where('project_id', $projects_id)->where('company_id', $authCompany->company_id)->get();
    $status = $findpam->isEmpty() ? 1 : 0;
    // dd($findpam);
    if ($status == 0) {
        $isCreatedss = [];
        foreach ($findpam as $key => $userId) {
            $isCreatedss = PrMemberManagment::create([
                'company_id' => auth()->user()->company_id,
                'user_id' => $userId->user_id, // Store the individual user ID
                'leavel' => $key + 1, // Set the leave to the user ID as well
                'material_request_id' => $material_requests_id ?? '',
                'project_id' => $projects_id ?? '',
                'pr_approval_member_id' => $userId->id ?? ''
            ]);
        }
    }
}

function compareAndCalculate($a, $b, $total)
{
    // Calculate the numerical difference
    $difference = abs((float)$a - (float)$b);

    // Calculate the total for addition and subtraction
    $totalAddition = ((float)$total) + ((float)$difference); // Total when adding
    $totalSubtraction = ((float)$total) - ((float)$difference); // Total when subtracting

    if ($a == $b) {
        return 0;
    } elseif ($a > $b) { //15>12
        return $totalSubtraction;
    } elseif ($a < $b) { //12<15
        return $totalAddition;
    }
}


if (!function_exists('log_daily')) {
    function log_daily(string $feature, string $message, string $functionName = '', string $level = 'info', $context = null)
    {
        // Sanitize feature name
        $feature = strtolower(trim($feature));

        // Create dynamic log file name with date
        $date = date('Y-m');
        $fileName = storage_path("logs/{$feature}-{$date}.log");

        // Create a new Monolog logger
        $monolog = new Logger($feature);
        $monolog->pushHandler(new StreamHandler($fileName, Logger::toMonologLevel($level)));

        // Wrap Monolog inside Laravel Logger
        $logger = new IlluminateLogger($monolog);

        // Final message format
        $fullMessage = $functionName ? "[{$functionName}] {$message}" : $message;

        // Ensure context is always an array
        if (is_string($context)) {
            // Decode JSON string to array
            $context = json_decode($context, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle JSON error
                $context = [];
            }
        }

        // Ensure context is an array
        if ($context === null || !is_array($context)) {
            $context = []; // Initialize as an empty array if context is null or not an array
        }

        // Call appropriate log level method
        $logger->{$level}($fullMessage, $context);
    }
}
if (!function_exists('sendSms')) {
    function sendSms($otp, $number)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('services.sms_gateway.url');
        $apiKey = config('services.sms_gateway.api_key');
        $senderId = config('services.sms_gateway.sender_id');
        $senderName = config('services.sms_gateway.sender_name');
        $defaultCountryCode = config('services.sms_gateway.default_country_code');
        $route = config('services.sms_gateway.route');
        $entityId = config('services.sms_gateway.entity_id');
        $templateId = config('services.sms_gateway.template_id');
        $otp = $otp; // Replace with the actual OTP value
        $number = $number; // Replace with the actual number
        $text = 'Dear User, Your one-time password (OTP) for registration with Sustrix Softwares Private Limited is ' . $otp . '. Website Link: https://koncite.com/';
        $queryParams = [
            'APIKey' => $apiKey,
            'senderid' => $senderId,
            'channel' => 2,
            'DCS' => 0,
            'flashsms' => 0,
            'number' => $defaultCountryCode . $number,
            'text' => $text,
            'route' => $route,
            'EntityId' => $entityId,
            'TemplateId' => $templateId,
        ];
        // dd($queryParams);
        $query = http_build_query($queryParams);
        $requestUrl = $url . '?' . $query;
        $request = new \GuzzleHttp\Psr7\Request('GET', $requestUrl);
        try {
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                return response()->json(['message' => 'SMS sent successfully']);
            } else {
                return response()->json(['message' => 'Failed to send SMS'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
        return back();
    }
    // https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=GDCV41mFykCotYkDlqmmcA&senderid=SUSTRI&channel=2&DCS=0&flashsms=0&number=8972344111&text="Dear User, Your one-time password (OTP) for registration with Sustrix Softwares Private Limited is 0987. Website Link: https://koncite.com/"&route=31&EntityId=1301174584493334245&dlttemplateid=1307174903083136401
}

function blank_if_null($value)
{
    return is_null($value) || $value === '' ? '' : $value;
}


if (!function_exists('check_null')) {
    function check_null($value, $default = ' ', $format = null)
    {
        if (
            is_null($value) ||
            $value === '' ||
            $value === 'NULL' ||
            (is_string($value) && strtoupper(trim($value)) === 'NULL')
        ) {
            return $default;
        }

        if ($format === 'number' && is_numeric($value)) {
            return (abs($value) < 0.01) ? $default : number_format($value, 2);
        }

        return $value;
    }
}

function getTotalInwardQty($materialId, $projectId, $companyId)
{
    $inwardGoodDetails = InwardGoodsDetails::where('materials_id', $materialId)
        ->whereHas('InvInwardGood', function ($query) use ($projectId, $companyId) {
            $query->whereHas('InvInward', function ($iq) use ($projectId, $companyId) {
                $iq->where('projects_id', $projectId)
                    ->where('company_id', $companyId);
            });
        })->get();
    // dd($inwardGoodDetails);
    $totalInward = $inwardGoodDetails->sum('accept_qty');
    return $totalInward;
}
function getTotalIssueQty($materialId, $projectId, $companyId)
{
    $invIssueList = InvIssuesDetails::where('materials_id', $materialId)
        ->whereHas('InvIssueGood', function ($query) use ($projectId, $companyId) {
            $query->whereHas('invIssue', function ($query) use ($projectId, $companyId) {
                $query->where('projects_id', $projectId)
                    ->where('company_id', $companyId);
            });
        })->get();
    // dd($invIssueList);
    $totalIssue = $invIssueList->sum('issue_qty');
    return $totalIssue;
}
function getTotalInwardQtyAssets($materialId, $projectId, $companyId)
{
    $inwardGoodDetails = InwardGoodsDetails::where('assets_id', $materialId)
        ->whereHas('InvInwardGood', function ($query) use ($projectId, $companyId) {
            $query->whereHas('InvInward', function ($iq) use ($projectId, $companyId) {
                $iq->where('projects_id', $projectId)
                    ->where('company_id', $companyId);
            });
        })->get();
    // dd($inwardGoodDetails->toArray());
    $totalInward = $inwardGoodDetails->sum('accept_qty');
    return $totalInward;
}
function getTotalIssueQtyAssets($materialId, $projectId, $companyId)
{
    $invIssueList = InvIssuesDetails::where('assets_id', $materialId)
        ->whereHas('InvIssueGood', function ($query) use ($projectId, $companyId) {
            $query->whereHas('invIssue', function ($query) use ($projectId, $companyId) {
                $query->where('projects_id', $projectId)
                    ->where('company_id', $companyId);
            });
        })->get();
    // dd($invIssueList->toArray());
    $totalIssue = $invIssueList->sum('issue_qty');
    return $totalIssue;
}
