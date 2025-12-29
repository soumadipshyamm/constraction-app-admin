<?php

namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Cms\MenuManagment;
use App\Models\Admin\Settings\settings;
use App\Http\Controllers\BaseController;
use App\Models\Admin\Settings\ContactReport;
use App\Models\Admin\Settings\ContactDetails;

class SettingsController extends BaseController
{
    public function contactDetails(Request $request)
    {
        $datas = ContactDetails::first();
        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {
                if ($request->uuid) {
                    $ContactDetails = ContactDetails::find($request->uuid);
                } else {
                    $ContactDetails = new ContactDetails();
                }
                $ContactDetails->ph_no = $request->ph_no;
                $ContactDetails->email = $request->email;
                $ContactDetails->address = $request->address;
                $ContactDetails->map_loc = $request->map_loc;
                $ContactDetails->facebook_link = $request->facebook_link;
                $ContactDetails->instagram_link = $request->instagram_link;
                $ContactDetails->twitter_link = $request->twitter_link;
                $ContactDetails->linkedin_link = $request->linkedin_link;
                $ContactDetails->description = $request->description;
                $ContactDetails->save();

                if ($ContactDetails) {
                    DB::commit();
                    return redirect()->route('admin.setting.contactDetails')->with('success', 'Contact Us Managment Updated Successfully');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return redirect()->route('admin.setting.contactDetails')->with('false', $e->getMessage());
            }
        }
        return view("Admin.settings.contact-details", compact('datas'));
    }
    public function contactReport(Request $request)
    {
        $datas = ContactReport::orderby('id', 'desc')->get();
        return view("Admin.settings.contact-report", compact('datas'));
    }
}
