<div
    class="modal fade"
    id="bs-update-modal"
    tabindex="-1"
    aria-labelledby="bs-update-modal"
    aria-hidden="true"
    >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
            <h4 class="modal-title" id="myLargeModalLabel">
            Create Account
            </h4>
            <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            id="closeUpdateUserModal"
            ></button>
        </div>
        <div class="modal-body">
            
            <form id="updateForm" enctype="multipart/form-data">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="example-email" class="">First Name</label>
                            <div class="">
                                <input type="hidden" id="id" name="id">
                                <input id="name" name="name" type="text" placeholder="Johnathan Doe" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="example-email" class="">Last Name</label>
                            <div class="">
                                <input id="last_name" name="last_name" type="text" placeholder="Johnathan Doe" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="example-email" class="">Email</label>
                            <div class="">
                                <input id="email" name="email" type="email" placeholder="johnathan@admin.com" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="example-email" class="">Phone</label>
                            <div class="">
                                <input id="phone" name="phone" type="phone" placeholder="123 456 7890" class="form-control form-control-line">
                            </div>
                        </div>
                    </div>
                    
                </div>

                

                <div class="mb-3">
                    <label for="example-email" class="">Change Password</label>
                    <div class="">
                        <input id="password"
                        name="password"
                        type="password" placeholder="Change Password" class="form-control form-control-line">
                    </div>
                    
                </div>

                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Role</label>
                    <div class="col-md-12">
                        <select name="role" id="role" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="example-email" class="col-md-12">Address</label>
                    <div class="col-md-12">
                        <textarea name="address" rows="5" class="form-control form-control-line"></textarea>
                    </div>
                </div>
            
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" type="button" id="updateUserButton">
                Save
            </button>
            <button
                type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start"
                data-bs-dismiss="modal">
                Close
            </button>
        </div>
    </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>