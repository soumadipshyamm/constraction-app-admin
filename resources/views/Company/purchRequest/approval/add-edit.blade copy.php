@extends('Company.layouts.app')
@section('pr-management-active', 'active')
@section('title', __('PR Member'))
@push('styles')
<style>
    .error {
        color: red;
    }

    .image-preview {
        width: 50px;
        height: 15px;
    }
</style>
@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner card">
        <!-- Dashboard Body -->
        <div class="dashboard_body">
            <!-- Company Details -->
            <div class="company-details mb-4">
                <h5>PR Allocation</h5>
            </div>
            <form method="POST" action="{{ route('company.pr.approval.add') }}" class="formSubmit fileUpload"
                enctype="multipart/form-data" id="UserForm">
                @csrf
                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_alloction" class="form-label">Project List</label>
                            <select name="material_request_id" id="material_request_id"
                                class="form-control d-flex materialRequestId">
                                <option value="">Select Project</option>
                                {{ getProject(isset($pid) ? $pid : '') }}
                                {{-- {{ getPrList(isset($test->id) ? $test->id : '') }} --}}
                            </select>
                            @if ($errors->has('material_request_id'))
                            <div class="error">{{ $errors->first('material_request_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="user_alloction" class="form-label">User Name</label>
                            @if (isset($findProjectApprovalMember) && $findProjectApprovalMember->isNotEmpty())
                            @foreach ($findProjectApprovalMember as $uid)
                            <div class="user-selection">
                                <select name="user_alloction[]" class="form-control m-2 user_alloction">
                                    class="form-control d-flex">
                                    <option value="">Select User</option>
                                    {!! getCompanyUserList($uid->user_id) !!}
                                </select>
                                <button type="button" class="btn btn-danger remove-user">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                            @endforeach
                            @else
                            <select name="user_alloction[]" id="user_alloction_default" class="form-control d-flex">
                                <option value="">Select User</option>
                                {!! getCompanyUserList(null) !!}
                            </select>
                            @endif

                            <div class="add-more-option"></div>
                            <button type="button" class="addmore btn btn-secondary mt-2">Add More</button>
                            @if ($errors->has('registration_name'))
                            <div class="error">{{ $errors->first('registration_name') }}</div>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_alloction" class="form-label">User Name</label>
                                <select name="user_alloction[]" id="user_alloction" class="form-control d-flex">
                                    <option value="">Select User</option>
                                    @if (isset($findProjectApprovalMember) && $findProjectApprovalMember->isNotEmpty())
                                        @foreach ($findProjectApprovalMember as $uid)
                                            {!! getCompanyUserList($uid?->user_id) !!}
                                        @endforeach
                                    @else
                                        {!! getCompanyUserList(null) !!}
                                    @endif
                                </select>
                                <div class="add-more-option"></div>
                                <button type="button" class="addmore btn btn-secondary mt-2">Add More</button>
                                @if ($errors->has('registration_name'))
                                    <div class="error">{{ $errors->first('registration_name') }}
                </div>
                @endif
        </div>
    </div> --}}
    <div class="col-md-12">
        <div class="dashboard-button">
            <a href="{{ route('company.project.list') }}" class="btn btn-danger">Cancel</a>
            {{-- <a href="{{ route('company.pr.approval.list') }}" class="btn btn-danger">Cancel</a> --}}
            <button type="submit" class="active btn btn-success">Create</button>
        </div>
    </div>
</div>
</form>
</div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
    // $(document).ready(function() {
    //     var materialRequestId = {{ $test->id ?? 'null' }};
    //     if (materialRequestId !== 'null') {
    //         getMaterialList(materialRequestId);
    //     }
    //     $(document).on('click', '.addmore', function(e) {
    //         e.preventDefault(); // Prevent default button action

    //         var newSelect = `
    //             <div class="user-selection">
    //                 <select name="user_alloction[]" class="form-control m-2 user_alloction">
    //                     <option value="">Select User</option>
    //                     {!! getCompanyUserList('') !!}
    //                 </select>
    //                 <button type="button" class="btn btn-danger remove-user">
    //                     <i class="fa fa-trash" aria-hidden="true"></i>
    //                 </button>
    //             </div>`;
    //         $('.add-more-option').append(newSelect); // Append new select after the current button
    //     });

    //     // Remove user selection
    //     $(document).on('click', '.remove-user', function(e) {
    //         e.preventDefault(); // Prevent default button action
    //         $(this).closest('.user-selection').remove(); // Remove the associated user selection
    //     });


    //     // $(".materialRequestId").on('change', function() {
    //     //     var materialRequestId = $(this).val()
    //     //     if (materialRequestId) {
    //     //         getMaterialList(materialRequestId);
    //     //     }
    //     // });

    //     // function getMaterialList(id) {
    //     //     if (!id) {
    //     //         console.error("Material request ID is required.");
    //     //         return;
    //     //     }
    //     //     $.ajax({
    //     //         url: baseUrl + `ajax/getprdetails`, // Ensure this route exists on the server
    //     //         type: 'POST',
    //     //         data: {
    //     //             id: id,
    //     //             _token: '{{ csrf_token() }}' // Include CSRF token for security
    //     //         },
    //     //         success: function(response) {
    //     //             if (!response || response.length === 0) {
    //     //                 console.error("No data found for the given material request ID.");
    //     //                 return;
    //     //             }
    //     //             var tableBody = $('#data-table tbody');
    //     //             tableBody.empty(); // Clear existing data
    //     //             $.each(response.material_request, function(index, item) {
    //     //                 var row = '<tr>' +
    //     //                     '<td>' + (index + 1) + '</td>' +
    //     //                     '<td>' + (item.materials?.name ?? '---') + '</td>' +
    //     //                     '<td>' + (item.activites?.activities ?? '---') +
    //     //                     '</td>' + // Activities
    //     //                     '<td>' + (item.qty ?? '---') + '</td>' + // Quantity
    //     //                     '<td>' + (item.date ?? '---') + '</td>' + // Date
    //     //                     '<td>' + (item.remarks ?? '---') + '</td>' +
    //     //                     '</tr>';
    //     //                 tableBody.append(row);
    //     //             });
    //     //         },
    //     //         error: function(xhr) {
    //     //             console.error("Error fetching PR details:", xhr.responseText);
    //     //         }
    //     //     });
    //     // }
    // });
</script>
@endpush
