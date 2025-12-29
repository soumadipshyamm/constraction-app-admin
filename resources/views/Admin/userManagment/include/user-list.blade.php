<table class="mb-0 table userDataTable">
    <thead>
        <tr>
            <th>#</th>
            {{-- <th>Profile Photo</th> --}}
            <th>Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Role Type</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($datas)
        @forelse ( $datas as $key=>$data )
        <tr>
            <td>{{ $key+1 }}</td>
            {{-- <td>
                <img src="{{ asset('profile_image/'.$data->profile_image) }}" width="100px" height="100px">
            </td> --}}
            <td>{{ $data->first_name }}</td>
            <td>{{ $data->email }}</td>
            <td>{{ $data->mobile_number }}</td>
            <td>{{ $data->role->name }}</td>
            <td>
                @if($data->role->slug!='super-admin')
                @if(checkAdminPermissions('admin-user',auth()->user()->admin_role_id,auth()->user()->id,'edit'))

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input statusChange" id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}" data-message="{{ $data->is_active ? 'deactive' : 'active' }}" data-table="users" name="example" {{ $data->is_active == 1 ?
                    'checked' : '' }}>
                    <label class="custom-control-label" for="switch{{ $data->uuid }}"></label>
                </div>
                @endif
                @endif
            </td>
            <td>
                @if(checkAdminPermissions('admin-user',auth()->user()->admin_role_id,auth()->user()->id,'edit'))
                @if($data->role->slug!='super-admin')
                <a href="{{ route('admin.userManagment.edit',$data->uuid) }}"><i class="fa fa-edit" style="cursor: pointer;" title="Edit"> </i></a>

                {{-- <i class="fa fa-eye" style="cursor: pointer;" title="View"> </i> --}}

                @if($data->id!='1')
                <a href="{{ route('admin.userManagment.userPermission',$data->uuid) }}"><i class="fa fa-cog" style="cursor: pointer;" title="Manage Permission"></i></a>

                @endif
                @if(checkAdminPermissions('admin-user',auth()->user()->admin_role_id,auth()->user()->id,'delete'))

                <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}" data-table="users" href="javascript:void(0)"><i class="fa fa-trash-alt" style="cursor: pointer;" title="Remove">
                    </i>
                </a>

                @endif
                @endif
                @endif
            </td>
        </tr>
        @empty
        @endforelse
        @endif

    </tbody>
</table>
<div class="ajax-pagination-div d-flex justify-content-center">
    @if (isset($datas))
    {!! $datas->links() !!}
    @endif
</div>