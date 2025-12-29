@extends('Admin.layouts.app')
@section('additional-purchase-active', 'active')
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
                    <a href="{{ route('admin.additionalFeatures.list') }}" type="button" class="btn-shadow btn btn-info">
                        Back
                    </a>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-12 card">
                    <div class="card-body">
                        <h5 class="card-title">Create Subscription</h5>
                        {{-- <div class="materials_tab">

                            <div class="tab-content" id="myTabContent">                                  --}}
                        {{-- ****************************************Add Features Purchase************************************ --}}
                        <div class="tab-pane fade show " id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                            <div class="tablesec-head blukup_head">
                                <form method="POST" action="{{ route('admin.additionalFeatures.add') }}" class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                                    @csrf
                                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                                    <div class="form-row subscriptionPackage">
                                        <div class="col-md-4">
                                            <label for="amount_inr" class="">Additional Project Cost
                                                (per
                                                project)</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-r1elative form-group">
                                                <label for="aditional_project_inr" class="">Price (In
                                                    ₹)</label>
                                                <input name="aditional_project_inr" id="aditional_project_inr" placeholder="Enter Price In INR" type="text" class="form-control" value="{{ old('aditional_project_inr', $data->aditional_project_inr ?? '') }}">
                                                @if ($errors->has('aditional_project_inr'))
                                                <div class="error">
                                                    {{ $errors->first('aditional_project_inr') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-r1elative form-group">
                                                <label for="aditional_project_usd" class="">Price (In
                                                    $)</label>
                                                <input name="aditional_project_usd" id="aditional_project_usd" placeholder="Enter Price In USD " type="text" class="form-control" value="{{ old('aditional_project_usd', $data->aditional_project_usd ?? '') }}">
                                                @if ($errors->has('aditional_project_usd'))
                                                <div class="error">
                                                    {{ $errors->first('aditional_project_usd') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row subscriptionPackage">
                                        <div class="col-md-4">
                                            <label for="amount_inr" class="">Additional User Cost (per
                                                user)</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-r1elative form-group">
                                                <label for="additional_users_inr" class="">Price (In
                                                    ₹)</label>
                                                <input name="additional_users_inr" id="additional_users_inr" placeholder="Enter Price In INR" type="text" class="form-control" value="{{ old('additional_users_inr', $data->additional_users_inr ?? '') }}">
                                                @if ($errors->has('additional_users_inr'))
                                                <div class="error">
                                                    {{ $errors->first('additional_users_inr') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-r1elative form-group">
                                                <label for="additional_users_usd" class="">Price (In
                                                    $)</label>
                                                <input name="additional_users_usd" id="additional_users_usd" placeholder="Enter Price In USD " type="text" class="form-control" value="{{ old('additional_users_usd', $data->additional_users_usd ?? '') }}">
                                                @if ($errors->has('additional_users_usd'))
                                                <div class="error">
                                                    {{ $errors->first('additional_users_usd') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
@endsection()
@push('scripts')
@endpush