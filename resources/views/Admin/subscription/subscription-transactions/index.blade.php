@extends('Admin.layouts.app')
@section('subscription-transactions-active', 'active')
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

                        <div> Subscription Transactions
                            <div class="page-title-subheading"> Subscription Transactions
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Subscription Transactions List</h5>
                            <div class="table-responsive table-scrollable" id="load_content">
                                <table class="mb-0 table dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company Name</th>
                                            <th>Company User</th>
                                            <th>Transaction ID</th>
                                            <th>Payment Method</th>
                                            {{-- <th>Payment Status</th> --}}
                                            <th>Payment Amount</th>
                                            <th>Payment Date</th>
                                            <th>Subscription Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $key => $transaction)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $transaction?->companys?->name ?? ' ' }}</td>
                                                <td>{{ $transaction?->users?->name ?? ' ' }}</td>
                                                <td>{{ $transaction?->transaction_id ?? ' ' }}</td>
                                                <td>{{ $transaction?->payment_method ?? ' ' }}</td>
                                                {{-- <td>{{ $transaction['payment_status'] }}</td> --}}
                                                <td>{{ isset($transaction) ? (float)$transaction->payment_amount / 100 : '' }}</td>
                                                <td>{{ $transaction?->created_at ?? '' }}</td>
                                                <td>{{ $transaction?->subscription_type ?? '' }}</td>
                                            </tr>
                                        @endforeach
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
