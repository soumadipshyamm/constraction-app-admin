<div class="modal fade" id="UpdatePassword" tabindex="-1" role="dialog" aria-labelledby="UpdatePasswordTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body add-modal">
                {{-- action="{{ route('admin.passwordUpdate') }}" data-url="{{ route('admin.passwordUpdate') }}" --}}
                <form method="POST"  class="formSubmit fileUpload"
                    enctype="multipart/form-data" id="UserForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 my-2">
                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="text" class="form-control" placeholder="Enter Old Password"
                                    id="old_password" name="old_password">
                            </div>
                        </div>
                        <div class="col-md-12 my-2">
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="text" class="form-control" id="new_password" name="new_password"
                                    placeholder="Enter your New Password">
                            </div>
                        </div>
                        <div class="col-md-12 my-2">
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="text" class="form-control" id="confirm_password" name="confirm_password"
                                    placeholder="Enter your Confirm Password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="reset" class="btn cancel-btn resetBtn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn save-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
