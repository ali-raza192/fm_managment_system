@extends('admin.master_dashboard')
@section('main')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Manage Accounts</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Manage Accounts</li>
            </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- multi-column ordering -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="border-bottom title-part-padding">
                  <h4 class="card-title mb-0" style="float: left;">Craete Accounts</h4>
                  <h4 class="card-title mb-0" style="float: right;"><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bs-add-modal">Add</button></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered display" style="width: 100%">
                      <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>

    </div> 
    
    {{-- ----------------------------------------------Add Modal ------------------------------------------------ --}}

    @include('admin.deputy_director_finance.partials.create')

    {{-- ----------------------------------------------Update Modal ------------------------------------------------ --}}

    @include('admin.deputy_director_finance.partials.update')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            var dataTable;
            initializeDataTable();
            function initializeDataTable() {
                if ($.fn.DataTable.isDataTable('#dataTable')) {
                    $('#dataTable').DataTable().destroy();
                }

                dataTable = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('accounts.data') }}',
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'email', name: 'email'},
                        {data: 'role', name: 'role'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                });
            }
            // validate add form input feilds
            $('#addForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password",
                    },
                    role: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please enter a first name',
                    },
                    last_name: {
                        required: 'Please enter a last name',
                    },
                    email: {
                        required: 'Please enter email address',
                    },
                    password: {
                        required: 'Please set a new password',
                    },
                    password_confirmation: {
                        required: 'Please confirm your password',
                    },
                    role: {
                        required: 'Please select one role',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
            // send ajax request for create user
            $("#addUserButton").click(function(e) {
                e.preventDefault();
                if ($("#addForm").valid()) {
                    var formData = new FormData($('#addForm')[0]);
                    $.ajax({
                        url: '{{ route('add.users') }}',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            var type = response['alert-type'];

                            if (type === 'success') {
                                $("#closeAddUserModal").click();
                                $("#addForm")[0].reset();
                                initializeDataTable();
                                toastr.success(response.message, 'Success');
                            } else {
                                toastr.error(response.message, 'Error');
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('An error occurred while creating the account.', 'Error');
                        }
                    });
                }
            });
            // Get Id of edit button
            $(document).on('click', '#edit-button', function(){
                var editButtonId = $(this).data('edit-button-id');
                updateUser(editButtonId);
            });
            // show data in users modal
            function updateUser(id) {
                // alert(id);
                $.ajax({
                    type: 'GET',
                    url: '/user/edit/data/' + id,
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        $("#id").val(data.editUser.id);
                        $("#name").val(data.editUser.name);
                        $("#last_name").val(data.editUser.last_name);
                        $("#email").val(data.editUser.email);
                        $("#phone").val(data.editUser.phone);
                        $("#role").val(data.editUser.role);
                        $("#address").val(data.editUser.address);
                    }    
                });
            }
            // send ajax request for update user
            $("#updateUserButton").click(function(e){
                e.preventDefault();
                var formData = new FormData($('#updateForm')[0]);
                $.ajax({
                    url: '{{ route('update.user') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var type = response['alert-type'];
                        if (type === 'success') {
                            $("#closeUpdateUserModal").click();
                            $("#updateForm")[0].reset();
                            initializeDataTable();
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while updating this account.', 'Error');
                    }

                });
            });
            // Get Id of delete button
            $(document).on('click', '#delete-button', function(){
                var deleteButtonId = $(this).data('delete-button-id');
                deleteUser(deleteButtonId);
            });
            // send ajax request for delete user
            function deleteUser(id) {
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this user!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'GET',
                            url: '/delete-user/' + id,
                            dataType: 'json',
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'User deleted successfully!',
                                    'success'
                                )
                                initializeDataTable();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Error deleting user. Please try again.',
                                    'error'
                                )
                            }
                        });
                    } else {
                        Swal.fire(
                            'Cancel Deletion',
                            'User deletion cancelled.',
                            'success'
                        )
                    }
                });
            }
            
        });
    </script>
@endsection