@extends('Admin.layouts.app')
@section('subscription-managment-active', 'active')
@section('title', __('Subscription'))
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
                        <div>Manage Subscripion
                            <div class="page-title-subheading">Manage Subscripion
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        {{-- @if (checkAdminPermissions('admin-user', auth()->user()->admin_role_id, auth()->user()->id, 'add')) --}}
                        <a href="{{ route('admin.subscription.add') }}" type="button" class="btn-shadow btn btn-info">
                            Add Subscription
                        </a>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">

                        <div class="card-body">
                            <h5 class="card-title">Subscripion List</h5>
                            <div class="table-responsive table-scrollable" id="load_content">
                                <table class="mb-0 table dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Created On</th>
                                            <th>Price(INR)</th>
                                            <th>Price(USD)</th>
                                            {{-- <th>Option</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($datas)
                                            @forelse($datas as $key => $data)
                                                <tr>
                                                    <td>
                                                        <p>#{{ $key + 1 }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $data->title }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $data->free_subscription == 1 ? 'Free' : 'Paid' }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $data->CreatedAt }}</p>
                                                    </td>
                                                    <td>
                                                        @if ($data->free_subscription !== 1)
                                                            <p>₹ {{ $data->amount_inr }}/{{ $data->payment_mode }}
                                                                <br>Trial:
                                                                <span style="color: red">{{ $data->trial_period ?? 0 }}
                                                                    Days</span>
                                                            </p>
                                                        @else
                                                            <p>------<br>Trial:
                                                                <span style="color: red">{{ $data->trial_period ?? 0 }}
                                                                    Days</span>
                                                            </p>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($data->free_subscription !== 1)
                                                            <p>$ {{ $data->amount_usd }}/{{ $data->payment_mode }}
                                                                <br>Trial:
                                                                <span style="color: red">{{ $data->trial_period ?? 0 }}
                                                                    Days</span>
                                                            </p>
                                                        @else
                                                            <p>------ <br>Trial:
                                                                <span style="color: red">{{ $data->trial_period ?? 0 }}
                                                                    Days</span>
                                                            </p>
                                                        @endif

                                                    </td>
                                                  
                                                    <td>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input statusChange"
                                                                id="switch{{ $data->uuid }}"
                                                                data-uuid="{{ $data->uuid }}"
                                                                data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                                data-table="subscription_packages" name="example"
                                                                {{ $data->is_active == 1 ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                for="switch{{ $data->uuid }}"></label>
                                                        </div>
                                                        <a href="{{ route('admin.subscription.edit', $data->uuid) }}"><i
                                                                class="fa fa-edit" style="cursor: pointer;"
                                                                title="Edit"></i></a>
                                                        <a
                                                            href="{{ route('admin.subscription.editSubscriptionOption', $data->uuid) }}"><i
                                                                class="fa fa-cog" style="cursor: pointer;"
                                                                title="Manage Permission"></i></a>

                                                        <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}"
                                                            data-table="subscription_packages" href="javascript:void(0)"><i
                                                                class="fa fa-trash-alt" style="cursor: pointer;"
                                                                title="Remove">
                                                            </i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <p>!No Data Found</p>
                                            @endforelse
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
@endsection()
@push('scripts')
@endpush
