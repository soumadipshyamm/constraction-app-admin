<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Cities;
use App\Models\User;
use App\Models\Company\Unit;
use Illuminate\Http\Request;
use App\Models\Company\Assets;
use App\Models\Company\Labour;
use App\Models\Company\Vendor;
use App\Models\Admin\AdminRole;
use App\Models\Company\Project;
use App\Models\Company\Companies;
use App\Models\Company\Materials;
use App\Models\Admin\Cms\HomePage;
use App\Models\Company\Activities;
use App\Models\Company\SubProject;
use App\Models\Admin\PageManagment;
use App\Models\Company\CompanyUser;
use App\Models\Admin\Cms\BannerPage;
use App\Models\Company\Company_role;
use App\Models\Company\OpeningStock;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\StoreWarehouse;
use App\Models\Admin\Cms\MenuManagment;
use App\Http\Controllers\BaseController;
use App\Models\Assets\AssetsOpeningStock;
use App\Models\Company\MaterialOpeningStock;
use App\Models\States;
use App\Models\Subscription\SubscriptionPackage;
use App\Models\Subscription\SubscriptionPackageOptions;

class AjaxController extends BaseController
{



    //    ******************************************************************************
    //    *****************************Company*************************************************
    //
    public function subprojects(Request $request)
    {
        dd($request->all());
    }
    public function getMaterials(Request $request, $id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        if ($request->ajax()) {
            // dd($id);
            // $id = uuidtoid($request->uuid, 'materials');
            $fetchIdExitOrNot = Materials::with('units')->where('id', $id)->where('company_id', $companyId)->first();
            return $fetchIdExitOrNot;
        }
        abort(405);
    }

    public function getStates(Request $request)
    {
        $states = States::where('country_id', $request->countryId)->get();
        return $states;
    }

    public function getCities(Request $request)
    {
        // dd($request->stateId);
        $cities = Cities::where('state_id', $request->stateId)->get();
        // dd($cities);
        return $cities;
    }


    public function setStatus(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $table = $request->find;
            $data = $request->value;
            //  $id = uuidtoid($request->uuid, $table);
            switch ($table) {
                case 'users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = User::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Users Status updated';
                    break;
                case 'admin_roles':
                    $id = $request->uuid;
                    $data = AdminRole::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Role Status updated';
                    break;
                case 'company_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyManagment::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Company Managment Status updated';
                    break;
                case 'page_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = PageManagment::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'page Managment Status updated';
                    break;
                case 'home_pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = HomePage::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Section Status updated';
                    break;
                case 'banner_pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = BannerPage::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Page Status updated';
                    break;
                case 'menu_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = MenuManagment::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Menu Status updated';
                    break;
                case 'company_users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyUser::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Users Status updated';
                    break;
                case 'labours':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Labour::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Labour Status updated';
                    break;
                case 'assets':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Assets::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Assets Status updated';
                    break;
                case 'vendors':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Vendor::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Vendor Status updated';
                    break;
                case 'opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = OpeningStock::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Opening Stock Status updated';
                    break;
                case 'assets_opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = AssetsOpeningStock::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Assets Opening Stock Status updated';
                    break;



                default:
                    return $this->responseJson(false, 200, 'Something Wrong Happened');
            }

            if ($data) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        }
        abort(405);
    }

    public function deleteData(Request $request)
    {
        // dd("dataaa");
        if ($request->ajax()) {
            $table = $request->find;
            switch ($table) {
                case 'users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = User::where('id', $id)->delete();
                    $message = 'Users Deleted';
                    break;
                case 'admin_roles':
                    $id = $request->uuid;
                    // dd($request->uuid);
                    $data = AdminRole::where('id', $id)->delete();
                    $message = 'Role  Deleted';
                    break;
                case 'company_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyManagment::where('id', $id)->delete();
                    $message = 'Company Managment  Deleted';
                    break;
                case 'company_users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyUser::where('id', $id)->delete();
                    $message = ' User  Deleted';
                    break;
                case 'page_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = pageManagment::where('id', $id)->delete();
                    $message = 'page Managment  Deleted';
                    break;
                case 'menu_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = MenuManagment::where('id', $id)->delete();
                    $message = 'Menu Managment  Deleted';
                    break;
                case 'company_roles':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Company_role::where('id', $id)->delete();
                    $message = 'Role Managment  Deleted';
                    break;
                case 'banner_pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = BannerPage::where('id', $id)->delete();
                    $message = 'Banner Managment  Deleted';
                    break;
                case 'subscription_packages':
                    $id = uuidtoid($request->uuid, $table);
                    $subscription = SubscriptionPackage::find($id);

                    if ($subscription->company == null) {
                        $data = $subscription->delete();
                        $message = 'Subscription Package Deleted';
                    } else {
                        $message = 'Subscription Package has an associated company, cannot delete';
                    }
                    break;
                    // **************************Company Managment*****************************************************************
                case 'companies':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Companies::where('id', $id)->delete();
                    $message = 'Companies Managment  Deleted';
                    break;
                case 'projects':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Project::where('id', $id)->delete();
                    $message = 'Project Managment  Deleted';
                    break;
                case 'sub_projects':
                    $id = uuidtoid($request->uuid, $table);
                    $data = SubProject::where('id', $id)->delete();
                    $message = 'Sub-Project Managment  Deleted';
                    break;
                case 'store_warehouses':
                    $id = uuidtoid($request->uuid, $table);
                    $data = StoreWarehouse::where('id', $id)->delete();
                    $message = 'Store/Warehouses Managment  Deleted';
                    break;
                case 'labours':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Labour::where('id', $id)->delete();
                    $message = 'Labour Managment  Deleted';
                    break;
                case 'units':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Unit::where('id', $id)->delete();
                    $message = 'Labour Managment  Deleted';
                    break;
                case 'assets':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Assets::where('id', $id)->delete();
                    $message = 'Assets Managment  Deleted';
                    break;
                case 'vendors':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Vendor::where('id', $id)->delete();
                    $message = 'Vendor Managment  Deleted';
                    break;
                case 'opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = OpeningStock::where('id', $id)->delete();
                    $message = 'Opening Stock Managment  Deleted';
                    break;
                case 'assets_opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = AssetsOpeningStock::where('id', $id)->delete();
                    $message = 'Assets Opening Stock Managment  Deleted';
                    break;
                case 'activities':
                    $id = $request->uuid;
                    $dataType = $request->dataType;
                    // dd($id);
                    if ($dataType === "activities") {
                        $data = Activities::where('id', $id)->delete();
                    } elseif ($dataType == 'subheading') {
                        $subheading = Activities::where('parent_id', $id)->get();
                        $data = Activities::where('id', $id)->delete();
                        foreach ($subheading as $deleteData) {
                            $data = Activities::where('id', $deleteData->id)->delete();
                        }
                    } elseif ($dataType == 'heading') {
                        $heading = Activities::where('parent_id', $id)->get();
                        if (empty($heading) || $heading == null || count($heading) == 0) {
                            // dd($id);
                            $data = Activities::where('id', $id)->delete();
                        } else {
                            Activities::where('id', $id)->delete();
                            foreach ($heading as $deleteData) {
                                $subHeadingId = Activities::where('parent_id', $deleteData->id)->get();
                                $data = Activities::where('id', $deleteData->id)->delete();
                                foreach ($subHeadingId as $deleteData) {
                                    $data = Activities::where('id', $deleteData->id)->delete();
                                    // dd($subHeadingId->toArray());
                                }
                            };
                        }
                    }

                    $message = 'Activities  Deleted';
                    break;
                case 'materials':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Materials::where('id', $id)->delete();
                    $message = 'Materials  Deleted';
                    break;
                case 'material_opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = MaterialOpeningStock::where('id', $id)->delete();
                    $message = 'Materials Opening Stock  Deleted';
                    break;
            }
            if (isset($data)) {
                return $this->responseJson(true, 200, $message);
            } else {
                $err_message = $message ? $message : "We are facing some technical issue now. Please try again after some time";
                return $this->responseJson(false, 500, $err_message);
            }
        } else {
            abort(405);
        }
    }
}
