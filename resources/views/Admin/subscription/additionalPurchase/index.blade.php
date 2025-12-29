@extends('Admin.layouts.app')
@section('additional-purchase-active', 'active')
@section('title', __('Additional Purchase'))
@push('styles')
@endpush
@section('content')

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Manage Additional Purchase
                        <div class="page-title-subheading">Additional Purchase
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('admin.additionalFeatures.add') }}" type="button" class="btn-shadow btn btn-info">
                        Additional Features
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Additional Purchase</h5>

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
                                    <input disabled class="form-control" value="{{ old('aditional_project_inr', $datas->aditional_project_inr ?? '') }}">
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
                                    <input disabled type="text" class="form-control" value="{{ old('aditional_project_usd', $datas->aditional_project_usd ?? '') }}">
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
                                    <input disabled class="form-control" value="{{ old('additional_users_inr', $datas->additional_users_inr ?? '') }}">
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
                                    <input disabled class="form-control" value="{{ old('additional_users_usd', $datas->additional_users_usd ?? '') }}">
                                    @if ($errors->has('additional_users_usd'))
                                    <div class="error">
                                        {{ $errors->first('additional_users_usd') }}
                                    </div>
                                    @endif
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
@endpush