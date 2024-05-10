<?php

use App\Http\Resources\API\Activities\DprActivitesResources;
use App\Http\Resources\API\DPR\DprLabourResources;
use App\Http\Resources\API\DPR\DprMaterialsResources;
use App\Http\Resources\DPR\DprAssetsResources;
use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use Illuminate\Support\Str;
use App\Models\Company\Unit;
use App\Models\Company\Teams;
use Intervention\Image\Image;
use Illuminate\Support\Carbon;
use App\Models\Admin\AdminMenu;
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
use App\Models\Company\ActivityHistory;
use App\Models\Company\AssetsHistory;
use App\Models\Company\Company_role_permission;
use App\Models\Company\Company_user_permission;
use App\Models\Company\LabourHistory;
use App\Models\Company\MaterialsHistory;
use App\Models\Inventory;
use App\Models\Subscription\SubscriptionOptions;
use App\Models\Subscription\SubscriptionPackage;
use App\Models\Subscription\SubscriptionPackageOptions;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

if (!function_exists('isSluggable')) {
    function isSluggable($value)
    {
        return Str::slug($value);
    }
}
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
if (!function_exists('getCompanyUser')) {
    function getCompanyUser($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = CompanyManagment::where('id', $companyId)->with('companyuser', 'companyuser.companyUserRole')->get();
        foreach ($datas as $key => $vals) {
            foreach ($vals->companyuser as $key => $val) {
                // dd($val);
                if ($temple_id == $val->id) {
                    echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
                } else {
                    echo "<option value='" . $val->id . "' >" . $val->name . "</option>";
                }
            }
        }
    }
}
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
if (!function_exists('getProject')) {
    function getProject($temple_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Project::where('company_id', $companyId)->get();
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
if (!function_exists('getchildActivites')) {
    function getchildActivites($heading_id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = Activities::with('parentActivites')
            ->where('company_id', $companyId)
            ->whereIn('type', ['heading', 'activites'])
            ->get();
        foreach ($data as $key => $val) {
            if ($val->type == 'heading') {
                echo "<option class='groupHeading' value='" . $val->id . "'>"  . $val->activities . "</option>"; // Close <option> tag properly
            }
            if (count($val->parentAndSelf) < 2) {
                foreach ($val->children as $childkey => $childval) {
                    if ($childval->type == 'activites') {
                        echo "<option value='" . $childval->id . "'>"  . $childval->activities . "</option>"; // Close <option> tag properly
                    }
                }
            }
        }
    }
}
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
                echo "<option value='" . $val->id . "' >"  . $val->activities . "</option>"; // Close <option> tag properly
            }
        } else {
            echo "<option value=''>No activities found</option>"; // Provide a message if no activities were found
        }
    }
}
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
if (!function_exists('getAllMenu')) {
    function getAllMenu()
    {
        $data = MenuManagment::where('is_active', '1')->get();
        // dd($data);
        return $data;
    }
}
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


// if (!function_exists('buildActivitesTreeHtml')) {
//     function buildActivitesTreeHtml($categories)
//     {
//         $options = '';
//         if (count($categories)) {
//             foreach ($categories as $category) {
//                 $options += '<option value="' . $category->id . '">' . $category->name . '</option>';
//                 if (!empty($category->children)) {
//                     buildActivitesTreeHtml($category->children);
//                 }
//             }
//         }
//         return $options;
//     }
// }
// function buildCategoryTreeHtml($categories, $number = 1)
// {
//     $options = '
//   ';
//     if (count($categories)) {
//         foreach ($categories as $key => $category) {
//             $options .= '<div class="structureb_head">
//             <div class="structureb_sub" style="display: block">
//               <div class="strucbhe_subbox">
//                 <div class="strucbhe_sing">
//                   <span class="add_newbox">
//                     <i class="fa fa-plus"></i>
//                   </span>
//                 </div>
//                 <div class="strucbhe_sing">
//                   <p>1.2.1</p>
//                 </div>
//                 <div class="strucbhe_sing strbhe_sgtitle">
//                   <p>PCC 1:2:4</p>
//                 </div><div class="strucbhe_sing">
//             <p>' . $category->activities . '</p>
//             </div><div class="strucbhe_sing">
//             <p>100</p>
//           </div>
//           <div class="strucbhe_sing">
//             <p>5000</p>
//           </div>
//           <div class="strucbhe_sing">
//             <p>500000</p>
//           </div>
//           <div class="strucbhe_sing"></div>
//           <div class="strucbhe_sing"></div>
//         </div>
//       </div>
//     </div>';
//             if ($category->children->isNotEmpty()) {
//                 $options .= buildCategoryTreeHtml($category->children);
//             }
//         }
//         $options .= '';
//     }
//     return $options;
// }


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
if (!function_exists('searchCompanyId')) {
    function searchCompanyId($authConpany)
    {
        // dd($authConpany);
        $employees = CompanyUser::findOrFail($authConpany);
        $companyId = $employees->company_id;
        return $companyId;
    }
}
// ******************************Activites***************************************************
if (!function_exists('getSubheading')) {
    function getSubheading($id)
    {
        $data = Activities::where('parent_id', $id)->get();

        return $data;
    }
}

if (!function_exists('getActivite')) {
    function getActivite($id)
    {
        $data = Activities::where('parent_id', $id)->get();
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
if (!function_exists('checkSubscribePackage')) {
    function checkSubscribePackage($id)
    {
        // dd($id);
        $data = CompanyManagment::where('id', $id)->first();
        $freeOrPaid = checkSubscription($data->is_subscribed);
        // dd($freeOrPaid);
        return $freeOrPaid;
    }
}
if (!function_exists('checkSubscription')) {
    function checkSubscription($id)
    {
        // dd($id);
        $data = SubscriptionPackage::where('id', $id)->first();
        // dd($data);
        return $data;
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
    function checkSubscriptionPermission($companyId,  $key)
    {
        // dd($companyId);
        $subscriptionId = checkSubscribePackage($companyId);
        if ($subscriptionId->free_subscription != 1) {
            $data = SubscriptionPackageOptions::where('subscription_packages_id', $subscriptionId->id)->where('subscription_key', $key)->first();
            return $data;
        }
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
                    $message = ' Fetch Assets History';;
                    break;
                case 5: //safeties
                    // $data = User::where('id', $id)->update(['is_active' => $data->is_active]);
                    $message = ' Fetch Safeties History';;
                    break;
                case 6: //hinderance
                    // $data = User::where('id', $id)->update(['is_active' => $data->is_active]);
                    $message = ' Fetch Hinderance History';;
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
    $pdf = Pdf::loadView($view, $data);

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
        $dbDetails = DB::table($table)
            ->select('id')
            ->where('unit', 'LIKE', "%{$name}%")->first();
        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            return false;
        }
    }
}
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
if (!function_exists('companyroleidtoname')) {
    function companyroleidtoname($id, $table)
    {
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
// if (!function_exists('genrateOtp')) {
//     function genrateOtp($digit = 6)
//     {
//         $generator = "1357902468";
//         $result = "";
//         for ($i = 1; $i <= $digit; $i++) {
//             $result .= substr($generator, (rand() % (strlen($generator))), 1);
//         }
//         return $result;
//     }
// }

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
if (!function_exists('genrateUniqueNo')) {
    function genrateUniqueNo()
    {
        $time = strtotime('today');
        $my = str_shuffle($time);
        return $my;
    }
}
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
if (!function_exists('imageResizeAndSave')) {
    function imageResizeAndSave($imageUrl, $type = 'post/image', $filename = null)
    {
        if (!empty($imageUrl)) {
            Storage::disk('public')->makeDirectory($type . '/60x60');
            $path60X60 = storage_path('app/public/' . $type . '/60x60/' . $filename);
            $image = Image::make($imageUrl)->resize(
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
            $image = Image::make($imageUrl)->resize(
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
if (!function_exists('formatTime')) {
    function formatTime($time)
    {
        return Carbon::parse($time)->format('dS M, Y, \\a\\t\\ g:i A');
    }
}
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
// if (!function_exists('getImgUpload')) {
//     function getImgUpload($file, $location)
//     {
//         $name = time() . rand(1, 100) . '.' . $file->extension();
//         $file->move(public_path($location), $name);
//         return $name;
//     }
// }

if (!function_exists('getImgUpload')) {
    function getImgUpload($file, $location)
    {
        if ($file !== null && is_object($file) && method_exists($file, 'isValid')) {
            $name = time() . rand(1, 100) . '.' . $file->extension();
            $file->move(public_path($location), $name);
            return $name;
        }
    }
}
// *******************************Inventory********************************************************
if (!function_exists('inventoryDataChecking')) {
    function inventoryDataChecking($data)
    {

        $authCompany = Auth::guard('company-api')->user()->company_id;
        if ($data['type'] == 'materials') {
            $data = Inventory::where('projects_id', $data['projects_id'])->where('materials_id', $data['materials_id'])->where('company_id', $authCompany)->first();
        } else {
            $data = Inventory::where('projects_id', $data['projects_id'])->where('assets_id', $data['materials_id'])->where('company_id', $authCompany)->first();
        }
        // dd($data);
        return $data;
    }
}

// ***************************Dashboard function**********************************************************************
if (!function_exists('projectwisedpr')) {
    function projectwisedpr($data)
    {
        $authCompany = Auth::guard('company')->user()->company_id;
        $fetchData = Dpr::where('company_id', 2)->where('projects_id', $data)->get();
        $dprwiseactiviteshistory = dprwiseactiviteshistory($fetchData);
        return $dprwiseactiviteshistory;
    }
}

if (!function_exists('dprwiseactiviteshistory')) {
    function dprwiseactiviteshistory($data)
    {
        $authCompany = Auth::guard('company')->user()->company_id;
        $fetchData = [];
        foreach ($data as $key => $did) {
            $activityData = ActivityHistory::select('activities_id', DB::raw('SUM(`qty`) as total_activity'))
                ->where('company_id', 2)
                ->where('dpr_id', $did->id)
                ->groupBy('activities_id')
                ->get();
            if (!empty($activityData) && count($activityData) > 0) {
                $fetchData[] = $activityData;
            }
        }
        $combinedCollection = collect($fetchData)->flatten();

        // Group the combined collection by activities_id and sum total_wise for each group
        // $groupedData = $combinedCollection->select('activities_id as activitiesId', 'total_wise as totalRate')->groupBy('activities_id')->map(function ($group) {
        //     return $group->sum('total_wise');
        // });

        // $groupedData = $combinedCollection->groupBy('activities_id')->map(function ($group) {
        //     return [
        //         'activitiesId' => $group->first()['activities_id'],
        //         'totalRate' => $group->sum('total_wise')
        //     ];
        // });

        $groupedData = $combinedCollection->groupBy('activities_id')->map(function ($group) {
            return [
                'activitiesId' => $group->first()['activities_id'],
                'total_activity' => $group->sum('total_activity')
            ];
        })->values()->all();
        // dd( $groupedData );

        // $groupedData->each(function ($sumTotalWise, $activitiesId) {
        //     echo "Activity ID: $activitiesId, Total Wise: $sumTotalWise\n";
        // });

        return $groupedData;
    }
}

// ***********************************Estimated Cost for Project**************************************************************

if (!function_exists('estimatedcost')) {
    function estimatedcost($data)
    {
        $authCompany = Auth::guard('company')->user()->company_id;
        // $fetchData = Activities::select( DB::raw('SUM(`qty`) as total_qty'),DB::raw('SUM(`amount`) as total_amount'))->where('company_id', 2)->where('project_id', $data)->get();
        $fetchData = Activities::select('id', 'qty', 'rate', 'amount', 'project_id')
            ->where(function ($query) {
                $query->whereNotNull('qty')
                    ->orWhereNotNull('rate')
                    ->orWhereNotNull('amount');
            })
            ->where('company_id', 2)
            ->where('project_id', 1)
            ->whereNull('deleted_at')
            ->get();

        $totalAmount = collect($fetchData)->sum(function ($item) {
            return (float) $item['amount'];
        });
        // $dprwiseactiviteshistory=dprwiseactiviteshistory($fetchData);
        // dd($fetchData->toArray());
        return $totalAmount;
    }
}


// *************************************************************************************************
if (!function_exists('estimatedcostforexecutedqty')) {
    function estimatedcostforexecutedqty($data, $pid)
    {
        // dd($data);
        $authCompany = Auth::guard('company')->user()->company_id;

        $data = [
            ['activitiesId' => 1, 'total_activity' => 230.0],
            ['activitiesId' => 2, 'total_activity' => 54.0],
            ['activitiesId' => 5, 'total_activity' => 122.0],
            ['activitiesId' => 43, 'total_activity' => 22.0],
            ['activitiesId' => 54, 'total_activity' => 122.0],
            ['activitiesId' => 55, 'total_activity' => 122.0],
            ['activitiesId' => 3, 'total_activity' => 62.0],
        ];


        $origenaldata = [
            [
                "id" => 1,
                "qty" => "45",
                "rate" => "4",
                "amount" => "180"
            ],
            [
                "id" => 2,
                "qty" => null,
                "rate" => "10",
                "amount" => "100"
            ],
            [
                "id" => 5,
                "qty" => "3",
                "rate" => "8000",
                "amount" => "24000"
            ],
            [
                "id" => 43,
                "qty" => "2500",
                "rate" => "8000",
                "amount" => "20000000"
            ],
            [
                "id" => 54,
                "qty" => null,
                "rate" => "10",
                "amount" => "100"
            ],
            [
                "id" => 55,
                "qty" => null,
                "rate" => "10",
                "amount" => "100"
            ],
            [
                "id" => 3,
                "qty" => null,
                "rate" => "10",
                "amount" => "200"
            ]

        ];


        // $fetchData = Activities::where('id', $data['activitiesId'])->where('company_id', 2)->where('project_id', 1)->get();
        // $fetchData = Activities::select(DB::raw('SUM(`qty`) as total_qty'), DB::raw('SUM(`amount`) as total_amount'))->where('company_id', 2)->where('project_id', 1)->get();

        // $fetchData = ActivityHistory::select('id', 'qty', 'total_qty', 'activities_id')
        //     // ->where(function ($query) {
        //     //     $query->whereNotNull('qty')
        //     //         ->orWhereNotNull('rate')
        //     //         ->orWhereNotNull('amount');
        //     // })
        //     ->where('company_id', 2)
        //     ->whereNull('deleted_at')
        //     ->toRawSql();

        // $totalAmount = collect($fetchData)->sum(function ($item) {
        //     return (float) $item['amount'];
        // });
        // $dprwiseactiviteshistory=dprwiseactiviteshistory($fetchData);
        // dd($fetchData);

        $fetchData = [];
        // foreach ($data as $key => $did) {
        $activityData = Activities::select('id', 'qty', 'rate', 'amount')
            ->where('company_id', 2)
            ->where('project_id', 1)
            // ->where('type', 'activites')
            // ->groupBy('id')k
            // ->whereNotNull('qty')
            // ->whereIn(['qty', '!=', null, 'rate', '!=', null, 'amount', '!=', null])
            // ->whereNotNull('qty')
            ->whereNotNull('rate')
            ->whereNotNull('amount')
            ->get();

        // dd($activityData->toArray());
        if (!empty($activityData) && count($activityData) > 0) {
            $fetchData[] = $activityData;
        }
        // }
        $combinedCollection = collect($fetchData)->flatten();
        // dd($combinedCollection);

        return $fetchData;
    }
}



// *************************************************************************************************
if (!function_exists('filterusernametoid')) {
    function filterusernametoid($name)
    {
        $authCompany = Auth::guard('company')->user()->company_id;
        $data = CompanyUser::where('name', 'LIKE', '%' . $name . '%')->where('company_id',  $authCompany)->first();
        return $data->id;
    }
}
// *************************************************************************************************
if (!function_exists('generatePdf')) {

    function generatePdf($view, $data, $filename)
    {
        $pdf = PDF::loadView($view, $data);
        $pdf->save(storage_path('app/public/' . $filename));
        return URL::to('/storage/' . $filename);
    }
}
// *************************************************************************************************
function checkAdminPermissions($menuName, $roleId, $userId, $action, $redirectionMode = false)
{
    if ($roleId == 1) :
        return true;
    else :
        $menuId = AdminMenu::where('slug', $menuName)->pluck('id')->first();
        if (!empty($menuId)) :
            $permissionDetails = AdminUserPermission::where('user_id', $userId)->where('menu_id', $menuId)->where('action', $action)->first();
            // $permissionDetails = AdminUserPermission::where('user_id', $userId)->where('menu_id', $menuId)->where('action', $action)->first();
            if (empty($permissionDetails)) :
                if ($redirectionMode) :
                    abort(403);
                else :
                    return false;
                endif;
            else :
                return true;
            endif;
        else :
            return false;
        endif;
    endif;
}
// function checkCompanyPermissions($menuName, $roleId, $userId, $action, $redirectionMode = false)
// {
//     if ($roleId == 10) :
//         return true;
//     else :
//         $menuId = Company_permission::where('slug', $menuName)->pluck('id')->first();
//         if (!empty($menuId)) :
//             $rolePermissionDetails = Company_role_permission::where('company_role_id', $roleId)->where('company_permission_id', $menuId)->where('action', $action)->first();
//             $permissionDetails = Company_user_permission::where('company_user_id', $userId)->where('company_permission_id', $menuId)->where('action', $action)->first();
//             if (empty($rolePermissionDetails)) :
//                 if (empty($permissionDetails)) :
//                     if ($redirectionMode) :
//                         abort(403);
//                     else :
//                         return false;
//                     endif;
//                 else :
//                      return false;
//                 endif;
//             else :
//                 return true;
//             endif;
//         else :
//             return false;
//         endif;
//     endif;
// }
function checkCompanyPermissions($menuName, $roleId, $userId, $action, $redirectionMode = false)
{
    $companyId = searchCompanyId($userId);
    $roleSlug = Company_role::where('id', $roleId)->where('company_id', $companyId)->first();
    // dd($roleId);
    if ($roleId == $roleId && $roleSlug->slug === 'super-admin') {
        return true; // User with role 10 has full access
    } else {
        $menuId = Company_permission::where('slug', $menuName)->pluck('id')->first();
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
