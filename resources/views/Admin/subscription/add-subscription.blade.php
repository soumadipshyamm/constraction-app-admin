@extends('Admin.layouts.app')
@section('subscription-managment-active', 'active')
@section('title', __('Dashboard'))
@push('styles')
    <style>
        .error {
            color: red;
        }

        .ck-editor__editable {
            min-height: 250px;
        }
    </style>
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
                        <div>Subscription
                            <div class="page-title-subheading">Create Subscription
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <a href="{{ route('admin.subscription.list') }}" type="button" class="btn-shadow btn btn-info">
                            Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <h5 class="card-title">Create Subscription </h5>
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="tablesec-head blukup_head">
                                    <form method="POST" action="{{ route('admin.subscription.add') }}"
                                        class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                                        @csrf
                                        {{-- @dd($data) --}}
                                        <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-r1elative form-group">
                                                    <label for="title" class="">Title</label>
                                                    <input name="title" id="title"
                                                        placeholder="Enter Subscription Title" type="text"
                                                        class="form-control" value="{{ old('title', $data->title ?? '') }}">
                                                    @if ($errors->has('title'))
                                                        <div class="error">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (!checkFreeSubscription() || (isset($data) && $data->free_subscription == 1))
                                                <div class="col-md-6">
                                                    <div class="position-r1elative form-group">
                                                        <label for="free_subscription" class="">Free
                                                            Subscription</label>
                                                        <input name="free_subscription" id="free_subscription"
                                                            type="checkbox" class="" value="1"
                                                            @if ($data->free_subscription == 1) checked @endif>

                                                        @if ($errors->has('free_subscription'))
                                                            <div class="error">
                                                                {{ $errors->first('free_subscription') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- @if (!checkFreeSubscription('') == false) --}}
                                        <div class="form-row subscriptionPackage">
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                    <label for="payment_mode" class="">Payment
                                                        Mode</label>
                                                    <select name="payment_mode" id="payment_mode" class="mb-2 form-control">
                                                        <option value="">----Select Payment Mode----</option>
                                                        <option value="month"
                                                            {{ isset($data->payment_mode) && $data->payment_mode == 'month' ? 'selected' : '' }}>
                                                            Monthly</option>
                                                        <option value="year"
                                                            {{ isset($data->payment_mode) && $data->payment_mode == 'year' ? 'selected' : '' }}>
                                                            Yearly</option>
                                                    </select>
                                                    @if ($errors->has('payment_mode'))
                                                        <div class="error">{{ $errors->first('payment_mode') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                    <label for="duration" class="">Duration</label>
                                                    <select name="duration" id="duration" class="mb-2 form-control">
                                                        <option value="">----Select Duration----</option>
                                                        <option value="1"
                                                            {{ isset($data->duration) && $data->duration == '1' ? 'selected' : '' }}>
                                                            1</option>
                                                        <option value="2"
                                                            {{ isset($data->duration) && $data->duration == '2' ? 'selected' : '' }}>
                                                            2</option>
                                                        <option value="3"
                                                            {{ isset($data->duration) && $data->duration == '3' ? 'selected' : '' }}>
                                                            3</option>
                                                        <option value="4"
                                                            {{ isset($data->duration) && $data->duration == '4' ? 'selected' : '' }}>
                                                            4</option>
                                                        <option value="5"
                                                            {{ isset($data->duration) && $data->duration == '5' ? 'selected' : '' }}>
                                                            5</option>
                                                        <option value="6"
                                                            {{ isset($data->duration) && $data->duration == '6' ? 'selected' : '' }}>
                                                            6</option>
                                                        <option value="7"
                                                            {{ isset($data->duration) && $data->duration == '7' ? 'selected' : '' }}>
                                                            7</option>
                                                        <option value="8"
                                                            {{ isset($data->duration) && $data->duration == '8' ? 'selected' : '' }}>
                                                            8</option>
                                                        <option value="9"
                                                            {{ isset($data->duration) && $data->duration == '9' ? 'selected' : '' }}>
                                                            9</option>
                                                        <option value="10"
                                                            {{ isset($data->duration) && $data->duration == '10' ? 'selected' : '' }}>
                                                            10</option>
                                                    </select>
                                                    @if ($errors->has('duration'))
                                                        <div class="error">
                                                            {{ $errors->first('duration') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-r1elative form-group">
                                                    <label for="amount_inr" class="">Amount(In ₹)</label>
                                                    <input name="amount_inr" id="amount_inr"
                                                        placeholder="Enter Amount In INR" type="text"
                                                        class="form-control"
                                                        value="{{ old('amount_inr', $data->amount_inr ?? '') }}">
                                                    @if ($errors->has('amount_inr'))
                                                        <div class="error">{{ $errors->first('amount_inr') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-r1elative form-group">
                                                    <label for="amount_usd" class="">Amount(In $)</label>
                                                    <input name="amount_usd" id="amount_usd"
                                                        placeholder="Enter Amount In USD " type="text"
                                                        class="form-control"
                                                        value="{{ old('amount_usd', $data->amount_usd ?? '') }}">
                                                    @if ($errors->has('amount_usd'))
                                                        <div class="error">{{ $errors->first('amount_usd') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row subscriptionPackage">
                                            <div class="col-md-6">
                                                <div class="position-r1elative form-group">
                                                    <label for="trial_period" class="">Trial Period(How Many
                                                        Days)</label>
                                                    <input name="trial_period" id="trial_period"
                                                        placeholder="Enter Trial Period" type="text"
                                                        class="form-control"
                                                        value="{{ old('trial_period', $data->trial_period ?? '') }}">
                                                    @if ($errors->has('trial_period'))
                                                        <div class="error">{{ $errors->first('trial_period') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row subscriptionPackage">
                                            <div class="col-md-12">
                                                <div class="position-r1elative form-group">
                                                    <label for="trial_period" class="">Details</label>
                                                    <textarea class="form-control" id="details" name="details" value="{{ old('details', $data->details ?? '') }}">{!! $data->details ?? '' !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- @endif --}}
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
@endsection()
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('details');
    </script>
    <script>
        $(document).ready(function() {
            // When the button is clicked, toggle the visibility of the element
            $("#free_subscription").click(function() {
                $(".subscriptionPackage").toggle();
            });
        });
    </script>
@endpush
