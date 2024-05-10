<?php

namespace App\Http\Controllers\Subscription;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Subscription\SubscriptionManagment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubscriptionManagmentController extends BaseController
{
    public function index(Request $request)
    {
        return view('Admin.subscription.index');
    }

    public function addaa(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'title' => 'required',
                    'free_subscription' => 'required|in:yes,no',
                    'payment_mode' => 'required|in:month,year',
                    'amount' => 'required|number',
                    'trial_period' => 'required|number',
                ]);
                dd($request->all());
                DB::beginTransaction();
                // if ($request->uuid) {
                //     try {
                //         $cid = uuidtoid($request->uuid, 'company_managments');
                //         $isCompaniesCreated = CompanyManagment::where('id', $cid)->update([
                //             'name' => $request->registration_name,
                //             'registration_no' => $request->company_registration_no,
                //             'address' => $request->company_address,
                //             'phone' => $request->company_phone,
                //             'website_link' => $request->website_link,
                //         ]);
                //         $uid = uuidtoid($request->cid, 'company_users');
                //         $fechPassword = CompanyUser::find($uid);
                //         // dd($fechPassword->password);
                //         $isCompanyUser = CompanyUser::where('id', $uid)->update([
                //             'name' => $request->user_name,
                //             'phone' => $request->phone,
                //             'email' => $request->email,
                //             'password' => $request->password ? Hash::make($request->password) : $fechPassword->password,
                //             'country' => $request->country,
                //             'city' => $request->city,
                //             'dob' => $request->dob,
                //             'designation' => $request->designation,
                //             'company_role_id' => 1,
                //             // 'profile_images' => $request->profile_images ?? getImgUpload($request->profile_images, 'profile_image'),
                //         ]);
                //         if ($isCompanyUser) {
                //             DB::commit();
                //             return redirect()
                //                 ->route('admin.companyManagment.list')
                //                 ->with('success', 'Company Managment Created Successfully');
                //         }
                //     } catch (\Exception $e) {
                //         DB::rollBack();
                //         logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                //         return redirect()
                //             ->route('admin.companyManagment.list')
                //             ->with('success', 'Company Managment Created Successfully');
                //     }
                // } else {
                try {
                    // dd($request->all());

                    $isCompanyUser = SubscriptionManagment::create([
                        'uuid' => str()::uuid(),
                        'name' => $request->user_name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'country' => $request->country,
                        'city' => $request->city,
                        'dob' => $request->dob,
                        'designation' => $request->designation,
                        'company_role_id' => 1,
                    ]);

                    if ($isCompanyUser) {
                        DB::commit();
                        return redirect()
                            ->route('admin.companyManagment.list')
                            ->with('success', 'Company Managment Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()
                        ->route('admin.companyManagment.list')
                        ->with('success', 'Company Managment Created Successfully');
                }
                // }
            }
            // return view('Frontend.auth.registration');
        }

        return view('Admin.subscription.add-subscription');
    }
}

// "uuid" => null
//   "title" => "swwwwwww"
//   "free_subscription" => "yes"
//   "payment_mode" => "monthly"
//   "amount" => "180"
//   "trial_period" => "30"

// Schema::create('subscription_managments', function (Blueprint $table) {
//     $table->id();
//     $table->uuid('uuid');
//     $table->string('title');
//     $table
//         ->tinyInteger('free_subscription')
//         ->default(false)
//         ->comment('0:Inactive,1:Active')
//         ->nullable();
//     $table->enum('payment_mode', ['month', 'year'])->nullable();
//     $table->float('amount', 8, 2)->nullable();
//     $table->integer('duration')->nullable();
//     $table->integer('trial_period')->nullable();
//     $table->enum('interval', ['day', 'week', 'month', 'year'])->nullable();

//     $table->timestamps();
//     $table->softDeletes();
// });
// }

// <tr>
//     <th>Aditional Fileds</th>
// </tr>
// <tr>
//     <td><input type="hidden" name="aditional_project_inr"
//             id="aditional_project_inr">Aditional Project
//         cost
//         In INR</td>
//     <td><input type="text"
//             name="aditional_project_inr[free]"
//             id="aditional_project_inr"></td>
// </tr>
// <tr>
//     <td><input type="hidden" name="aditional_project_usd"
//             id="aditional_project_usd">Aditional Project
//         cost
//         In USD</td>
//     <td><input type="text"
//             name="aditional_project_usd[free]"
//             id="aditional_project_usd"></td>
// </tr>
// <tr>
//     <td><input type="hidden" name="additional_users_inr"
//             id="additional_users_inr">Additional Users cost
//         In INR </td>
//     <td><input type="text"
//             name="additional_users_inr[free]"
//             id="additional_users_inr"></td>
// </tr>
// <tr>
//     <td><input type="hidden" name="additional_users_usd"
//             id="additional_users_usd">Additional Users cost
//         In USD</td>
//     <td><input type="text"
//             name="additional_users_usd[free]"
//             id="additional_users_usd"></td>
// </tr>



// ALTER TABLE `subscription_package_options` ADD `mobile_app` VARCHAR(10) NULL DEFAULT 'no' AFTER `subscription_key`, ADD `web_app` VARCHAR(10) NULL DEFAULT 'no' AFTER `mobile_app`, ADD `po` VARCHAR(10) NULL DEFAULT 'no' AFTER `web_app`, ADD `approvals` VARCHAR(10) NULL DEFAULT 'no' AFTER `po`, ADD `inward_multiple_option` VARCHAR(10) NULL DEFAULT 'no' AFTER `approvals`, ADD `subproject_creation` VARCHAR(10) NULL DEFAULT 'no' AFTER `inward_multiple_option`, ADD `multistores_project` VARCHAR(10) NULL DEFAULT 'no' AFTER `subproject_creation`, ADD `inventory` VARCHAR(10) NULL DEFAULT '0' AFTER `multistores_project`, ADD `activities` VARCHAR(10) NULL DEFAULT '0' AFTER `inventory`, ADD `material` VARCHAR(10) NULL DEFAULT '0' AFTER `activities`, ADD `no_of_users` VARCHAR(10) NULL DEFAULT '0' AFTER `material`;




// {
//     "status": true,
//     "response_code": 200,
//     "message": "Fetch Activities History",
//     "data": [
//         {
//             "id": 134,
//             "uuid": "0283d5a1-93a6-4532-b6b3-2953e991ca17",
//             "activities": {
//                 "id": 139,
//                 "uuid": "f1ee7c29-da41-4b8d-986b-4e5d37a69d4e",
//                 "parent_id": 137,
//                 "sl_no": "1.1",
//                 "type": "activites",
//                 "activities": "Activites",
//                 "qty": 2500,
//                 "rate": "8000",
//                 "amount": "20000000",
//                 "start_date": "",
//                 "end_date": "",
//                 "heading": {
//                     "id": 137,
//                     "uuid": "cec43508-243b-43ad-bcc6-f1822d0b208e",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 2,
//                         "uuid": "d2497cc2-69f3-4c54-95a7-25f4cd2facc7",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "parent": {
//                     "id": 137,
//                     "uuid": "cec43508-243b-43ad-bcc6-f1822d0b208e",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 2,
//                         "uuid": "d2497cc2-69f3-4c54-95a7-25f4cd2facc7",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "unit_id": {
//                     "id": 12,
//                     "uuid": "03d3047d-3fc6-4089-ad1d-27389a072cb2",
//                     "unit": "sssssss",
//                     "unit_coversion": "2",
//                     "unit_coversion_factor": "33333"
//                 },
//                 "project": {
//                     "id": 3,
//                     "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                     "project_name": "Testing Project one",
//                     "planned_start_date": "2024-01-01",
//                     "address": "kolkata",
//                     "planned_end_date": "2024-09-10",
//                     "own_project_or_contractor": "yes",
//                     "project_completed": "no",
//                     "project_completed_date": null,
//                     "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                     "companies": {
//                         "id": 3,
//                         "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                         "registration_name": "KP Builders Ltd",
//                         "company_registration_no": "qwe3432",
//                         "registered_address": "kolkata",
//                         "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                     },
//                     "client": {
//                         "id": 11,
//                         "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                         "client_name": "soumadiipp_hazaaaaa",
//                         "client_designation": "manager",
//                         "client_email": "awsq@abc.com",
//                         "client_phone": "1234567123",
//                         "client_mobile": "1234123890",
//                         "client_company_name": "SFTT PVT LTD",
//                         "client_company_address": "kolkata"
//                     }
//                 },
//                 "subproject": {
//                     "id": 2,
//                     "uuid": "d2497cc2-69f3-4c54-95a7-25f4cd2facc7",
//                     "name": "sft subproject_qqwww",
//                     "start_date": "2023-10-05",
//                     "end_date": "2023-11-05",
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     }
//                 },
//                 "activitiesHistory": {
//                     "id": 134,
//                     "uuid": "0283d5a1-93a6-4532-b6b3-2953e991ca17",
//                     "activities_id": 139,
//                     "qty": 10,
//                     "total_qty": "",
//                     "remaining_qty": 2480,
//                     "completion": 4,
//                     "vendors_id": null,
//                     "img": "",
//                     "remarkes": "testtttt",
//                     "company_id": 1,
//                     "dpr_id": 12,
//                     "is_active": 1,
//                     "created_at": "2024-02-28T14:17:26.000000Z",
//                     "updated_at": "2024-02-28T14:17:26.000000Z",
//                     "deleted_at": null
//                 }
//             },
//             "vendors_id": null,
//             "qty": 10,
//             "completion": 4,
//             "img": "",
//             "remarkes": "testtttt",
//             "dpr_id": 12,
//             "total_qty": "",
//             "remaining_qty": 2480
//         },
//         {
//             "id": 133,
//             "uuid": "40d4885f-ae0e-4803-ad60-11d76863cb4b",
//             "activities": {
//                 "id": 140,
//                 "uuid": "4238cd45-e723-462b-bec3-f69142d475b3",
//                 "parent_id": 138,
//                 "sl_no": "1.1",
//                 "type": "activites",
//                 "activities": "Sub Activites 1.1",
//                 "qty": 4,
//                 "rate": "8000",
//                 "amount": "32000",
//                 "start_date": "",
//                 "end_date": "",
//                 "heading": {
//                     "id": 138,
//                     "uuid": "d2e8137f-082d-474b-bf76-45e2f0d38786",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading-1.1",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 10,
//                         "uuid": "4b866d62-4b31-4f0a-a117-8840beb63acf",
//                         "project_name": "SFT Project",
//                         "planned_start_date": "2023-12-02",
//                         "address": "abcssd@abc.com",
//                         "planned_end_date": "2023-12-16",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169723911.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 10,
//                             "uuid": "4d808248-9712-47f2-bff3-f45ed10bafcf",
//                             "client_name": "ssssss",
//                             "client_designation": "Manager",
//                             "client_email": "soussma@sft.com",
//                             "client_phone": "1234567890",
//                             "client_mobile": "1234567890",
//                             "client_company_name": "abcd",
//                             "client_company_address": "Kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 3,
//                         "uuid": "bda25bf2-966e-4eb4-ae6d-6227ad0012cf",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "parent": {
//                     "id": 138,
//                     "uuid": "d2e8137f-082d-474b-bf76-45e2f0d38786",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading-1.1",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 10,
//                         "uuid": "4b866d62-4b31-4f0a-a117-8840beb63acf",
//                         "project_name": "SFT Project",
//                         "planned_start_date": "2023-12-02",
//                         "address": "abcssd@abc.com",
//                         "planned_end_date": "2023-12-16",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169723911.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 10,
//                             "uuid": "4d808248-9712-47f2-bff3-f45ed10bafcf",
//                             "client_name": "ssssss",
//                             "client_designation": "Manager",
//                             "client_email": "soussma@sft.com",
//                             "client_phone": "1234567890",
//                             "client_mobile": "1234567890",
//                             "client_company_name": "abcd",
//                             "client_company_address": "Kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 3,
//                         "uuid": "bda25bf2-966e-4eb4-ae6d-6227ad0012cf",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "unit_id": {
//                     "id": 12,
//                     "uuid": "03d3047d-3fc6-4089-ad1d-27389a072cb2",
//                     "unit": "sssssss",
//                     "unit_coversion": "2",
//                     "unit_coversion_factor": "33333"
//                 },
//                 "project": {
//                     "id": 10,
//                     "uuid": "4b866d62-4b31-4f0a-a117-8840beb63acf",
//                     "project_name": "SFT Project",
//                     "planned_start_date": "2023-12-02",
//                     "address": "abcssd@abc.com",
//                     "planned_end_date": "2023-12-16",
//                     "own_project_or_contractor": "yes",
//                     "project_completed": "no",
//                     "project_completed_date": null,
//                     "logo": "http://127.0.0.1:8080/logo/170169723911.jpg",
//                     "companies": {
//                         "id": 3,
//                         "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                         "registration_name": "KP Builders Ltd",
//                         "company_registration_no": "qwe3432",
//                         "registered_address": "kolkata",
//                         "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                     },
//                     "client": {
//                         "id": 10,
//                         "uuid": "4d808248-9712-47f2-bff3-f45ed10bafcf",
//                         "client_name": "ssssss",
//                         "client_designation": "Manager",
//                         "client_email": "soussma@sft.com",
//                         "client_phone": "1234567890",
//                         "client_mobile": "1234567890",
//                         "client_company_name": "abcd",
//                         "client_company_address": "Kolkata"
//                     }
//                 },
//                 "subproject": {
//                     "id": 3,
//                     "uuid": "bda25bf2-966e-4eb4-ae6d-6227ad0012cf",
//                     "name": "sft subproject_qqwww",
//                     "start_date": "2023-10-05",
//                     "end_date": "2023-11-05",
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     }
//                 },
//                 "activitiesHistory": {
//                     "id": 133,
//                     "uuid": "40d4885f-ae0e-4803-ad60-11d76863cb4b",
//                     "activities_id": 140,
//                     "qty": 10,
//                     "total_qty": "",
//                     "remaining_qty": -16,
//                     "completion": 4,
//                     "vendors_id": null,
//                     "img": "",
//                     "remarkes": "testtttt",
//                     "company_id": 1,
//                     "dpr_id": 12,
//                     "is_active": 1,
//                     "created_at": "2024-02-28T14:17:26.000000Z",
//                     "updated_at": "2024-02-28T14:17:26.000000Z",
//                     "deleted_at": null
//                 }
//             },
//             "vendors_id": null,
//             "qty": 10,
//             "completion": 4,
//             "img": "",
//             "remarkes": "testtttt",
//             "dpr_id": 12,
//             "total_qty": "",
//             "remaining_qty": -16
//         },
//         {
//             "id": 132,
//             "uuid": "f3551c62-1d63-4b0c-96a8-9dfd318d5b66",
//             "activities": {
//                 "id": 139,
//                 "uuid": "f1ee7c29-da41-4b8d-986b-4e5d37a69d4e",
//                 "parent_id": 137,
//                 "sl_no": "1.1",
//                 "type": "activites",
//                 "activities": "Activites",
//                 "qty": 2500,
//                 "rate": "8000",
//                 "amount": "20000000",
//                 "start_date": "",
//                 "end_date": "",
//                 "heading": {
//                     "id": 137,
//                     "uuid": "cec43508-243b-43ad-bcc6-f1822d0b208e",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 2,
//                         "uuid": "d2497cc2-69f3-4c54-95a7-25f4cd2facc7",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "parent": {
//                     "id": 137,
//                     "uuid": "cec43508-243b-43ad-bcc6-f1822d0b208e",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 2,
//                         "uuid": "d2497cc2-69f3-4c54-95a7-25f4cd2facc7",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "unit_id": {
//                     "id": 12,
//                     "uuid": "03d3047d-3fc6-4089-ad1d-27389a072cb2",
//                     "unit": "sssssss",
//                     "unit_coversion": "2",
//                     "unit_coversion_factor": "33333"
//                 },
//                 "project": {
//                     "id": 3,
//                     "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                     "project_name": "Testing Project one",
//                     "planned_start_date": "2024-01-01",
//                     "address": "kolkata",
//                     "planned_end_date": "2024-09-10",
//                     "own_project_or_contractor": "yes",
//                     "project_completed": "no",
//                     "project_completed_date": null,
//                     "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                     "companies": {
//                         "id": 3,
//                         "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                         "registration_name": "KP Builders Ltd",
//                         "company_registration_no": "qwe3432",
//                         "registered_address": "kolkata",
//                         "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                     },
//                     "client": {
//                         "id": 11,
//                         "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                         "client_name": "soumadiipp_hazaaaaa",
//                         "client_designation": "manager",
//                         "client_email": "awsq@abc.com",
//                         "client_phone": "1234567123",
//                         "client_mobile": "1234123890",
//                         "client_company_name": "SFTT PVT LTD",
//                         "client_company_address": "kolkata"
//                     }
//                 },
//                 "subproject": {
//                     "id": 2,
//                     "uuid": "d2497cc2-69f3-4c54-95a7-25f4cd2facc7",
//                     "name": "sft subproject_qqwww",
//                     "start_date": "2023-10-05",
//                     "end_date": "2023-11-05",
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     }
//                 },
//                 "activitiesHistory": {
//                     "id": 134,
//                     "uuid": "0283d5a1-93a6-4532-b6b3-2953e991ca17",
//                     "activities_id": 139,
//                     "qty": 10,
//                     "total_qty": "",
//                     "remaining_qty": 2480,
//                     "completion": 4,
//                     "vendors_id": null,
//                     "img": "",
//                     "remarkes": "testtttt",
//                     "company_id": 1,
//                     "dpr_id": 12,
//                     "is_active": 1,
//                     "created_at": "2024-02-28T14:17:26.000000Z",
//                     "updated_at": "2024-02-28T14:17:26.000000Z",
//                     "deleted_at": null
//                 }
//             },
//             "vendors_id": null,
//             "qty": 10,
//             "completion": 4,
//             "img": "",
//             "remarkes": "testtttt",
//             "dpr_id": 12,
//             "total_qty": "2500",
//             "remaining_qty": 2490
//         },
//         {
//             "id": 131,
//             "uuid": "cc921dc8-82e0-4d4d-826e-08a60f28a977",
//             "activities": {
//                 "id": 140,
//                 "uuid": "4238cd45-e723-462b-bec3-f69142d475b3",
//                 "parent_id": 138,
//                 "sl_no": "1.1",
//                 "type": "activites",
//                 "activities": "Sub Activites 1.1",
//                 "qty": 4,
//                 "rate": "8000",
//                 "amount": "32000",
//                 "start_date": "",
//                 "end_date": "",
//                 "heading": {
//                     "id": 138,
//                     "uuid": "d2e8137f-082d-474b-bf76-45e2f0d38786",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading-1.1",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 10,
//                         "uuid": "4b866d62-4b31-4f0a-a117-8840beb63acf",
//                         "project_name": "SFT Project",
//                         "planned_start_date": "2023-12-02",
//                         "address": "abcssd@abc.com",
//                         "planned_end_date": "2023-12-16",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169723911.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 10,
//                             "uuid": "4d808248-9712-47f2-bff3-f45ed10bafcf",
//                             "client_name": "ssssss",
//                             "client_designation": "Manager",
//                             "client_email": "soussma@sft.com",
//                             "client_phone": "1234567890",
//                             "client_mobile": "1234567890",
//                             "client_company_name": "abcd",
//                             "client_company_address": "Kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 3,
//                         "uuid": "bda25bf2-966e-4eb4-ae6d-6227ad0012cf",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "parent": {
//                     "id": 138,
//                     "uuid": "d2e8137f-082d-474b-bf76-45e2f0d38786",
//                     "parent_id": "",
//                     "sl_no": "1",
//                     "type": "heading",
//                     "activities": "Heading-1.1",
//                     "qty": "",
//                     "rate": "",
//                     "amount": "",
//                     "start_date": "",
//                     "end_date": "",
//                     "heading": null,
//                     "parent": {},
//                     "unit_id": {},
//                     "project": {
//                         "id": 10,
//                         "uuid": "4b866d62-4b31-4f0a-a117-8840beb63acf",
//                         "project_name": "SFT Project",
//                         "planned_start_date": "2023-12-02",
//                         "address": "abcssd@abc.com",
//                         "planned_end_date": "2023-12-16",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169723911.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 10,
//                             "uuid": "4d808248-9712-47f2-bff3-f45ed10bafcf",
//                             "client_name": "ssssss",
//                             "client_designation": "Manager",
//                             "client_email": "soussma@sft.com",
//                             "client_phone": "1234567890",
//                             "client_mobile": "1234567890",
//                             "client_company_name": "abcd",
//                             "client_company_address": "Kolkata"
//                         }
//                     },
//                     "subproject": {
//                         "id": 3,
//                         "uuid": "bda25bf2-966e-4eb4-ae6d-6227ad0012cf",
//                         "name": "sft subproject_qqwww",
//                         "start_date": "2023-10-05",
//                         "end_date": "2023-11-05",
//                         "project": {
//                             "id": 3,
//                             "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                             "project_name": "Testing Project one",
//                             "planned_start_date": "2024-01-01",
//                             "address": "kolkata",
//                             "planned_end_date": "2024-09-10",
//                             "own_project_or_contractor": "yes",
//                             "project_completed": "no",
//                             "project_completed_date": null,
//                             "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                             "companies": {
//                                 "id": 3,
//                                 "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                                 "registration_name": "KP Builders Ltd",
//                                 "company_registration_no": "qwe3432",
//                                 "registered_address": "kolkata",
//                                 "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                             },
//                             "client": {
//                                 "id": 11,
//                                 "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                                 "client_name": "soumadiipp_hazaaaaa",
//                                 "client_designation": "manager",
//                                 "client_email": "awsq@abc.com",
//                                 "client_phone": "1234567123",
//                                 "client_mobile": "1234123890",
//                                 "client_company_name": "SFTT PVT LTD",
//                                 "client_company_address": "kolkata"
//                             }
//                         }
//                     },
//                     "activitiesHistory": null
//                 },
//                 "unit_id": {
//                     "id": 12,
//                     "uuid": "03d3047d-3fc6-4089-ad1d-27389a072cb2",
//                     "unit": "sssssss",
//                     "unit_coversion": "2",
//                     "unit_coversion_factor": "33333"
//                 },
//                 "project": {
//                     "id": 10,
//                     "uuid": "4b866d62-4b31-4f0a-a117-8840beb63acf",
//                     "project_name": "SFT Project",
//                     "planned_start_date": "2023-12-02",
//                     "address": "abcssd@abc.com",
//                     "planned_end_date": "2023-12-16",
//                     "own_project_or_contractor": "yes",
//                     "project_completed": "no",
//                     "project_completed_date": null,
//                     "logo": "http://127.0.0.1:8080/logo/170169723911.jpg",
//                     "companies": {
//                         "id": 3,
//                         "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                         "registration_name": "KP Builders Ltd",
//                         "company_registration_no": "qwe3432",
//                         "registered_address": "kolkata",
//                         "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                     },
//                     "client": {
//                         "id": 10,
//                         "uuid": "4d808248-9712-47f2-bff3-f45ed10bafcf",
//                         "client_name": "ssssss",
//                         "client_designation": "Manager",
//                         "client_email": "soussma@sft.com",
//                         "client_phone": "1234567890",
//                         "client_mobile": "1234567890",
//                         "client_company_name": "abcd",
//                         "client_company_address": "Kolkata"
//                     }
//                 },
//                 "subproject": {
//                     "id": 3,
//                     "uuid": "bda25bf2-966e-4eb4-ae6d-6227ad0012cf",
//                     "name": "sft subproject_qqwww",
//                     "start_date": "2023-10-05",
//                     "end_date": "2023-11-05",
//                     "project": {
//                         "id": 3,
//                         "uuid": "b5115609-22de-438c-9b50-d701803047ed",
//                         "project_name": "Testing Project one",
//                         "planned_start_date": "2024-01-01",
//                         "address": "kolkata",
//                         "planned_end_date": "2024-09-10",
//                         "own_project_or_contractor": "yes",
//                         "project_completed": "no",
//                         "project_completed_date": null,
//                         "logo": "http://127.0.0.1:8080/logo/170169728328.jpg",
//                         "companies": {
//                             "id": 3,
//                             "uuid": "2515cd56-63a1-4dda-b7ec-4ad6d4a79f19",
//                             "registration_name": "KP Builders Ltd",
//                             "company_registration_no": "qwe3432",
//                             "registered_address": "kolkata",
//                             "logo": "http://127.0.0.1:8080/logo/170169719799.png"
//                         },
//                         "client": {
//                             "id": 11,
//                             "uuid": "1a7ea77b-b421-49f4-857b-f4791de62a12",
//                             "client_name": "soumadiipp_hazaaaaa",
//                             "client_designation": "manager",
//                             "client_email": "awsq@abc.com",
//                             "client_phone": "1234567123",
//                             "client_mobile": "1234123890",
//                             "client_company_name": "SFTT PVT LTD",
//                             "client_company_address": "kolkata"
//                         }
//                     }
//                 },
//                 "activitiesHistory": {
//                     "id": 133,
//                     "uuid": "40d4885f-ae0e-4803-ad60-11d76863cb4b",
//                     "activities_id": 140,
//                     "qty": 10,
//                     "total_qty": "",
//                     "remaining_qty": -16,
//                     "completion": 4,
//                     "vendors_id": null,
//                     "img": "",
//                     "remarkes": "testtttt",
//                     "company_id": 1,
//                     "dpr_id": 12,
//                     "is_active": 1,
//                     "created_at": "2024-02-28T14:17:26.000000Z",
//                     "updated_at": "2024-02-28T14:17:26.000000Z",
//                     "deleted_at": null
//                 }
//             },
//             "vendors_id": null,
//             "qty": 10,
//             "completion": 4,
//             "img": "",
//             "remarkes": "testtttt",
//             "dpr_id": 12,
//             "total_qty": "4",
//             "remaining_qty": -6
//         }
//     ]
// }
