@extends('Admin.layouts.app')
@section('subscription-managment-active', 'active')
@section('title', __('Dashboard'))
@push('styles')
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-add-user text-success">
                            </i>
                        </div>
                        <div>Subscription Managment
                            <div class="page-title-subheading">Create Subscription
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <a href="{{ route('subscription.list') }}" type="button" class="btn-shadow btn btn-info">
                            Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <h5 class="card-title">Create Subscription Managment</h5>
                            <div class="materials_tab">
                                <div class="tab-content" id="myTabContent">
                                    <!-- ****************************************Subscription Option************************************* -->
                                    <div class="tablesec-head blukup_head">
                                        <form method="POST" action="{{ route('subscription.addSubscriptionOption') }}"
                                            class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                                            @csrf
                                            {{-- @dd($datas) --}}
                                            <input type="hidden" name="uuid" id="uuid"
                                                value="{{ $datas[0]->subscription_packages_id ?? '' }}">
                                            <input type="hidden" name="id" id="id" value="{{ $datas ?? '' }}">
                                            <table>
                                                <thead>
                                                    <th>Basic options</th>
                                                    <th>Permission</th>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($datas) --}}
                                                    <tr>
                                                        <td><input type="hidden" name="mobile_app" id="mobile_app">Mobile
                                                            App
                                                            Use</td>
                                                        <td>
                                                            <input type="radio" name="mobile_app[free]"
                                                                id="mobile_app_free" value="yes"
                                                                {{ isset($datas[0]->subscription_key) && $datas[0]->subscription_key == 'mobile_app' && $datas[0]->is_subscription === 'yes' ? 'checked' : '' }}>
                                                            <label for="mobile_app_free">Yes</label>

                                                            <input type="radio" name="mobile_app[free]"
                                                                id="mobile_app_not_free" value="no"
                                                                {{ isset($datas[0]->subscription_key) && $datas[0]->subscription_key == 'mobile_app' && $datas[0]->is_subscription === 'no' ? 'checked' : '' }}>
                                                            <label for="mobile_app_not_free">No</label>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="web_app" id="web_app">Web
                                                            & App Use</td>
                                                        <td><input type="radio" name="web_app[free]" id="web_app_free"
                                                                value="yes"
                                                                {{ isset($datas[1]->subscription_key) && $datas[1]->subscription_key == 'web_app' && $datas[1]->is_subscription === 'yes' ? 'checked' : '' }}>
                                                            <label for="mobile_app_free">Yes</label>
                                                            <input type="radio" name="web_app[free]" id="web_app_free"
                                                                value="no"
                                                                {{ isset($datas[1]->subscription_key) && $datas[1]->subscription_key == 'web_app' && $datas[1]->is_subscription === 'no' ? 'checked' : '' }}>
                                                            <label for="mobile_app_not_free">No</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Add On Features</th>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="po" id="po">PO</td>
                                                        <td><input type="radio" name="po[free]" id="po_free"
                                                                value="yes"
                                                                {{ isset($datas[2]->subscription_key) && $datas[2]->subscription_key == 'po' && $datas[2]->is_subscription === 'yes' ? 'checked' : '' }}>
                                                            <label for="mobile_app_free">Yes</label>
                                                            <input type="radio" name="po[free]" id="po_free"
                                                                value="no"
                                                                {{ isset($datas[2]->subscription_key) && $datas[2]->subscription_key == 'po' && $datas[2]->is_subscription === 'no' ? 'checked' : '' }}>
                                                            <label for="mobile_app_not_free">No</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="approvals" id="approvals">Approvals
                                                        </td>
                                                        <td><input type="radio" name="approvals[free]" id="approvals_free"
                                                                value="yes"
                                                                {{ isset($datas[3]->subscription_key) && $datas[3]->subscription_key == 'approvals' && $datas[3]->is_subscription === 'yes' ? 'checked' : '' }}>
                                                            <label for="approvals_free">Yes</label>
                                                            <input type="radio" name="approvals[free]" id="approvals_free"
                                                                value="no"
                                                                {{ isset($datas[3]->subscription_key) && $datas[3]->subscription_key == 'approvals' && $datas[3]->is_subscription === 'no' ? 'checked' : '' }}>
                                                            <label for="approvals_free">No</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="inward_multiple_option"
                                                                id="inward_multiple_option">Inward multiple
                                                            options (Such as from PO)</td>
                                                        <td><input type="radio" name="inward_multiple_option[free]"
                                                                id="inward_multiple_option" value="yes"
                                                                {{ isset($datas[4]->subscription_key) && $datas[4]->subscription_key == 'inward_multiple_option' && $datas[4]->is_subscription === 'yes' ? 'checked' : '' }}>
                                                            <label for="mobile_app_free">Yes</label>
                                                            <input type="radio" name="inward_multiple_option[free]"
                                                                id="inward_multiple_option_free" value="no"
                                                                {{ isset($datas[4]->subscription_key) && $datas[4]->subscription_key == 'inward_multiple_option' && $datas[4]->is_subscription === 'no' ? 'checked' : '' }}>
                                                            <label for="inward_multiple_option">No</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="subproject_creation"
                                                                id="subproject_creation">Subproject Creation
                                                            (such as Wings /Blocks/Sections)
                                                        </td>
                                                        <td><input type="radio" name="subproject_creation[free]"
                                                                id="subproject_creation_free" value="yes"
                                                                {{ isset($datas[5]->subscription_key) && $datas[5]->subscription_key == 'subproject_creation' && $datas[5]->is_subscription === 'yes' ? 'checked' : '' }}>
                                                            <label for="subproject_creation">Yes</label>
                                                            <input type="radio" name="subproject_creation[free]"
                                                                id="subproject_creation_free" value="no"
                                                                {{ isset($datas[5]->subscription_key) && $datas[5]->subscription_key == 'subproject_creation' && $datas[5]->is_subscription === 'no' ? 'checked' : '' }}>
                                                            <label for="subproject_creation">No</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="hidden" name="multistores_project"
                                                                id="multistores_project">Multistores in same
                                                            project</td>
                                                        <td><input type="radio" name="multistores_project[free]"
                                                                id="multistores_project_free" value="yes"
                                                                {{ isset($datas[6]->subscription_key) && $datas[6]->subscription_key == 'multistores_project' && $datas[6]->is_subscription === 'yes' ? 'checked' : '' }}>
                                                            <label for="multistores_project">Yes</label>
                                                            <input type="radio" name="multistores_project[free]"
                                                                id="multistores_project_free" value="no"
                                                                {{ isset($datas[6]->subscription_key) && $datas[6]->subscription_key == 'multistores_project' && $datas[6]->is_subscription === 'no' ? 'checked' : '' }}>
                                                            <label for="multistores_project">No</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Aditional Add On Features</th>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="inventory" id="inventory">Work
                                                            progress & Inventory
                                                        </td>
                                                        <td>
                                                            <input type="text" name="inventory[free]" id="inventory"
                                                                value="{{ isset($datas[7]) && $datas[7]->subscription_key == 'inventory' ? $datas[7]->is_subscription : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="activities"
                                                                id="activities">Activities creation
                                                        </td>
                                                        <td>
                                                            <input type="text" name="activities[free]" id="activities"
                                                                value="{{ isset($datas[8]) && $datas[8]->subscription_key == 'activities' ? $datas[8]->is_subscription : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="material" id="material">Material
                                                            or asset Creation
                                                        </td>
                                                        <td>
                                                            <input type="text" name="material[free]" id="material"
                                                                value="{{ isset($datas[9]) && $datas[9]->subscription_key == 'material' ? $datas[9]->is_subscription : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="no_of_users" id="no_of_users">No
                                                            users
                                                        </td>
                                                        <td>
                                                            <input type="text" name="no_of_users[free]"
                                                                id="no_of_users"
                                                                value="{{ isset($datas[10]) && $datas[10]->subscription_key == 'no_of_users' ? $datas[10]->is_subscription : '' }}">
                                                        </td>
                                                    </tr>
                                                    {{-- @endif --}}
                                                </tbody>
                                            </table>

                                            <button class="mt-2 btn btn-primary" type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection()
@push('scripts')
    <script>
        $(document).ready(function() {
            // When the button is clicked, toggle the visibility of the element
            $("#free_subscription").click(function() {
                $(".subscriptionPackage").toggle();
            });
        });
    </script>
@endpush

{{--
"po" => array:1 [▶]
"approvals" => array:1 [▶]
"inward_multiple_option" => array:1 [▶]
"subproject_creation" => array:1 [▶]
"multistores_project" => array:1 [▶]
"inventory" => array:1 [▶]
"activities" => array:1 [▶]
"material" => array:1 [▶]
"no_of_users" => array:1 [▶] --}}
