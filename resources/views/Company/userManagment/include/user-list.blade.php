<table class="mb-0 table userDataTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Profile Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Role Type</th>
            <th>Reporting Person</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($datas)
            @foreach ($datas as $key => $employee)
                @if ($employee && $employee->companyUserRole)
                    @php
                        $roleId = $employee->companyUserRole->id;
                        $currentUserRoleId = Auth::guard('company')->user()->company_role_id;
                        $img = $employee?->profile_images
                            ? asset('profile_image/' . $employee?->profile_images)
                            : asset('company_assets/images/user-images.jpg');
                    @endphp

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <img src="{{ $img }}" width="100px" height="100px">
                        </td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->companyUserRole->name ?? '' }}</td>
                        <td><i class="fa-regular fa-user fa-lg" style="color: #63E6BE;"></i><strong> {{ $employee?->reportingPerson?->name ?? '' }}</strong>
                            <span>{{ $employee?->reportingPerson?->designation ?? '' }}</span>
                        </td>
                        <td>
                            {{-- @if ($employee?->companyUserRole->id != null && $employee?->companyUserRole?->id != 1 && $employee?->companyUserRole->id != Auth::guard('company')->user()->company_role_id) --}}
                            {{-- @if ($datauser->role->slug != 'super-admin') --}}
                            {{-- @if (checkAdminPermissions('admin-user', auth()->user()->admin_role_id, auth()->user()->id, 'edit'))
                --}}
                            @if ($roleId !== null && $roleId !== 1 && $roleId !== $currentUserRoleId)
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input statusChange"
                                        id="switch{{ $employee->uuid }}" data-uuid="{{ $employee->uuid }}"
                                        data-model="company"
                                        data-message="{{ $employee->is_active ? 'deactive' : 'active' }}"
                                        data-table="company_users" name="example"
                                        {{ $employee->is_active == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="switch{{ $employee->uuid }}"></label>
                                </div>
                            @endif
                            {{-- @endif --}}
                        </td>
                        <td>
                            {{-- @if ($employee->companyUserRole?->id != null && $employee->companyUserRole?->id != 1 && $employee->companyUserRole?->id != Auth::guard('company')->user()->company_role_id) --}}
                            {{-- @if (checkAdminPermissions('admin-user', auth()->user()->admin_role_id, auth()->user()->id, 'edit'))
                --}}
                            @if ($roleId !== null && $roleId !== 1 && $roleId !== $currentUserRoleId)
                                {{-- @if ($employee->role->slug != 'super-admin') --}}
                                <a href="{{ route('company.userManagment.edit', $employee->uuid) }}"><i
                                        class="fa fa-edit" style="cursor: pointer;" title="Edit"> </i></a>
                                {{-- @if ($employee->id != '1') --}}
                                <a href="{{ route('company.userManagment.userPermission', $employee->uuid) }}"><i
                                        class="fa fa-cog" style="cursor: pointer;" title="Manage Permission"></i></a>

                                {{-- @endif --}}
                                {{-- @if (checkAdminPermissions('admin-user', auth()->user()->admin_role_id, auth()->user()->id, 'delete'))
                --}}
                                <a class="deleteData text-danger" data-uuid="{{ $employee->uuid }}"
                                    data-model="company" data-table="company_users" href="javascript:void(0)"><i
                                        class="fa fa-trash-alt" style="cursor: pointer;" title="Remove">
                                    </i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach




















        @endif
    </tbody>
</table>
<div class="ajax-pagination-div d-flex justify-content-center">
    {{-- @if (isset($datas))
    {!! $datas->links() !!}
    @endif --}}
</div>
