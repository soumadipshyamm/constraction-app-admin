@extends('Admin.layouts.app')
@section('Company-active', 'active')
@section('title', __('Preview Company Details'))
@push('styles')
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-tools icon-gradient bg-happy-itmeo">
                            </i>
                        </div>
                        <div>List Preview Company Details
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <a href="{{ route('admin.companyManagment.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">List Company Details</h5>
                            <div class="table-responsive">
                                <table class="mb-0 table ">
                                    <tbody>
                                        {{-- @dd($datas) --}}
                                        @if ($datas)
                                            <tr>
                                                <td><strong>Company Details</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>{{ $datas->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Registration No</td>
                                                <td>{{ $datas->registration_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>{{ $datas->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{{ $datas->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Website Link</td>
                                                <td>{{ $datas->website_link }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Contact Person Details</strong></td>
                                            </tr>

                                            <tr>
                                                <td>Name</td>
                                                <td>{{ $datas?->companyUsers->name ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>{{ $datas?->companyUsers->phone ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{ $datas?->companyUsers->email ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Designation</td>
                                                <td>{{ $datas?->companyUsers->designation ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Date of Birth</td>
                                                <td>{{ $datas?->companyUsers->dob ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Country</td>
                                                <td>{{ $datas?->companyUsers->country ?? '' }}</td>
                                            </tr>

                                            <tr>
                                                <td>City</td>
                                                <td>{{ $datas?->companyUsers->city ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Role</td>
                                                {{-- <td>{{ $datas->companyuser->first()->company_role_id, '!=null' ? companyroleidtoname($datas?->companyUsers->company_role_id, 'company_roles') : '' }} --}}
                                                {{-- </td> --}}
                                                <td>
                                                    @if ($datas->companyuser->isNotEmpty() && $datas->companyUsers->company_role_id !== null)
                                                        {{ companyroleidtoname($datas->companyUsers->company_role_id, 'company_roles') }}
                                                    @endif
                                                </td>

                                            </tr>
                                            <tr>
                                                <td><strong>Subcritions Details</strong></td>
                                            </tr>

                                            
                                                <tr>
                                                    <td>Title</td>
                                                    <td>{{ $fetchSubscription->title }}</td>

                                                </tr>
                                                <tr>
                                                    <td>Free Subscription</td>
                                                    <td>{{ $fetchSubscription->free_subscription }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Mode</td>
                                                    <td>{{ $fetchSubscription->payment_mode }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Amount Inr</td>
                                                    <td>{{ $fetchSubscription->amount_inr }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Amount Usd</td>
                                                    <td>{{ $fetchSubscription->amount_usd }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Duration</td>
                                                    <td>{{ $fetchSubscription->duration }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Trial Period</td>
                                                    <td>{{ $fetchSubscription->trial_period }}</td>
                                                </tr>
                                          
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush


{{-- array:17 [▼ // app\Http\Controllers\Admin\CompanyManagmentController.php:158
  "id" => 2
  "uuid" => "a7033e51-bdf5-4001-982f-e718cf1b476a"
  "name" => "ABC PVT. LTD."
  "registration_no" => "1234DERTY"
  "phone" => "08972344111"
  "address" => "kolkata"
  "website_link" => null
  "country" => null
  "country_name" => null
  "state" => null
  "city" => null
  "profile_images" => null
  "is_active" => 1
  "created_at" => "2023-08-21T16:38:40.000000Z"
  "updated_at" => "2023-08-28T14:30:35.000000Z"
  "deleted_at" => null
  "companyuser" => array:1 [▼
    0 => array:20 [▼
      "id" => 1
      "uuid" => "7370ec16-8211-4bef-9d2c-e3b0a7455f11"
      "name" => "Ram Dasa"
      "email" => "abcd@abc.com"
      "password" => "$2y$10$PyStzfjM6/Jfi5C.YxTH5u.APYJCWzA3LcKm386JoOVYtuf3gPnG."
      "phone" => "08972344111"
      "alternet_phone" => null
      "address" => null
      "designation" => "Admin"
      "dob" => "2023-08-16"
      "country" => "India"
      "state" => null
      "city" => "select"
      "profile_images" => "169261612021.png"
      "company_role_id" => 1
      "is_active" => 1
      "created_at" => "2023-08-21T16:38:40.000000Z"
      "updated_at" => "2023-08-28T14:46:49.000000Z"
      "deleted_at" => null
      "pivot" => array:2 [▶]
    ] --}}
