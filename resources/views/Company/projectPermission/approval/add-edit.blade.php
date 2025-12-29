@extends('Company.layouts.app')
@section('project-permission-active', 'active')
@section('title', __('Project Allocation'))
@push('styles')
    <style>
        .error {
            color: red;
        }

        .image-preview {
            width: 50px;
            height: 15px;
        }

        .pr-aloc-submit {
            display: flex;
            float: right;
            flex-wrap: nowrap;
            padding-bottom: 5px;
        }

        .user-selection {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .remove-user {
            margin-left: 10px;
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
                    <h5>Project Allocation</h5>
                </div>
                <div class="container">
                    <h2>Project and User Allocation</h2>
                    <form id="user-allocation-form" method="POST"
                        action="{{ route('company.projectPermission.approval.add') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="project_id" class="form-label">Project List</label>
                                    <select name="project_id" id="project_id" class="form-control materialRequestId"
                                        required>
                                        <option value="">Select Project</option>
                                        {{ getProject(isset($pid) ? $pid : '') }}
                                    </select>
                                    @if ($errors->has('project_id'))
                                        <div class="error">{{ $errors->first('project_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_alloction" class="form-label">User Name</label>
                                    <div id="user-selection-container">
                                        @if (isset($findProjectApprovalMember) && $findProjectApprovalMember->isNotEmpty())
                                            @foreach ($findProjectApprovalMember as $uid)
                                                <div class="user-selection">
                                                    <select name="user_alloction[]" class="form-control user_alloction"
                                                        required>
                                                        <option value="">Select User</option>
                                                        {!! getCompanyUserList($uid->company_user_id) !!}
                                                    </select>
                                                    <button type="button" class="btn btn-danger remove-user">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="user-selection">
                                                <select name="user_alloction[]" class="form-control user_alloction"
                                                    required>
                                                    <option value="">Select User</option>
                                                    {!! getCompanyUserList(null) !!}
                                                </select>
                                                <button type="button" class="btn btn-danger remove-user">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="addmore btn btn-secondary mt-2">
                                        <i class="fa fa-plus"></i> Add More Users
                                    </button>
                                    @if ($errors->has('user_alloction'))
                                        <div class="error">{{ $errors->first('user_alloction') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success pr-aloc-submit">
                            <i class="fa fa-save"></i> Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add more user selection
            document.querySelector('.addmore').addEventListener('click', function() {
                var container = document.getElementById('user-selection-container');
                var newSelection = document.createElement('div');
                newSelection.className = 'user-selection';
                newSelection.innerHTML = `
                    <select name="user_alloction[]" class="form-control user_alloction" required>
                        <option value="">Select User</option>
                        {!! getCompanyUserList(null) !!}
                    </select>
                    <button type="button" class="btn btn-danger remove-user">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                `;
                container.appendChild(newSelection);
            });

            // Remove user selection
            document.getElementById('user-selection-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-user') || e.target.closest('.remove-user')) {
                    const userSelections = document.querySelectorAll('.user-selection');
                    if (userSelections.length > 1) {
                        e.target.closest('.user-selection').remove();
                    } else {
                        alert('At least one user must be selected');
                    }
                }
            });

            // Form submission
            document.getElementById('user-allocation-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const projectId = document.getElementById('project_id').value;
                if (!projectId) {
                    alert('Please select a project');
                    return;
                }

                const userSelections = document.querySelectorAll('.user_alloction');
                let valid = true;
                let selectedUsers = [];

                userSelections.forEach(select => {
                    if (!select.value) {
                        valid = false;
                        select.classList.add('is-invalid');
                    } else {
                        select.classList.remove('is-invalid');
                        selectedUsers.push(select.value);
                    }
                });

                // Check for duplicate users
                const uniqueUsers = new Set(selectedUsers);
                if (uniqueUsers.size !== selectedUsers.length) {
                    alert('Duplicate users are not allowed');
                    return;
                }

                if (valid) {
                    this.submit();
                } else {
                    alert('Please fill all required fields');
                }
            });

            // Project change event
            document.getElementById('project_id').addEventListener('change', function() {
                const projectId = this.value;
                if (projectId) {
                    // You can add AJAX call here to load project-specific data if needed
                    // fetchProjectUsers(projectId);
                }
            });
        });

        // Function to fetch project users if needed
        function fetchProjectUsers(projectId) {
            fetch(`${baseUrl}ajax/project-users/${projectId}`, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Handle the response data
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error fetching project users:', error);
                });
        }
    </script>
@endpush
