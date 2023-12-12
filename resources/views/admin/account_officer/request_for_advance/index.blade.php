@extends('admin.master_dashboard')
@section('main')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-12 align-self-center">
                <h3 class="text-themecolor mb-0">Approve Advance</h3>
                <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Approve Advance</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="border-bottom title-part-padding">
                  <h4 class="card-title mb-0" style="float: left;">Assign Advance</h4>
                  <h4 class="card-title mb-0" style="float: right;"><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bs-add-modal">Add</button></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered display" style="width: 100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>DDO</th>
                          <th>Advance</th>
                          <th>Status</th>
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

    @include('admin.account_officer.request_for_advance.partials.create')

    {{-- ----------------------------------------------Update Modal ------------------------------------------------ --}}

    @include('admin.account_officer.request_for_advance.partials.update')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function (){
            var dataTable;

            initializeDataTable();

            function initializeDataTable() {
                if ($.fn.DataTable.isDataTable('#dataTable')) {
                    $('#dataTable').DataTable().destroy();
                }

                dataTable = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('requested.advance.list') }}',
                    columns: [
                    {data: 'id', name: 'id'},
                    {data: 'ddo_name', name: 'ddo_name'},
                    {data: 'advance', name: 'advance'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            }
            // validate assign ddos form input feilds
            $('#myForm').validate({
                rules: {
                    ddo: {
                    required: true,
                    },
                    advance: {
                    required: true,
                    },
                },
                messages: {
                    ddo: {
                    required: 'Please select DDO',
                    },
                    advance: {
                    required: 'Please Enter Advance',
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
            // send ajax request for assign ddos
            $("#addButton").click(function(e) {
                e.preventDefault();
                if ($("#myForm").valid()) {
                    var formData = new FormData($('#myForm')[0]);
                    $.ajax({
                        url: '{{ route('create.assigned.advance') }}',
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
                                $("#myForm")[0].reset();
                                $("#closeAddModal").click();
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
                updateData(editButtonId);
            });
            // show data in users modal
            function updateData(id) {
                // alert(id);
                $.ajax({
                    type: 'GET',
                    url: '/requested/advance/edit/data/' + id,
                    dataType: 'json',
                    success: function(data) {
                    // console.log(data);
                    $("#ddo_id").val(data.editData.id);
                    $("#ddo").val(data.editData.ddo_id);
                    $("#advance").val(data.editData.advance);
                    }    
                });
            }
            // send ajax request for update data
            $("#updateButton").click(function(e){
                e.preventDefault();
                var formData = new FormData($('#updateForm')[0]);
                $.ajax({
                    url: '{{ route('update.data.of.requested.advance') }}',
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
                        $("#closeUpdateModal").click();
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

            $(document).on('click', '#delete-button', function (){
                var changeStatusButton = $(this).data('delete-button-id');
                deleteData(changeStatusButton);
            });

            function deleteData(id){
                // alert(id);
                $.ajax({
                type: 'GET',
                url: '/delete/advance/' + id,
                dataType: 'json',
                success: function(data) {
                    initializeDataTable();
                    // console.log(data);
                }    
                });
            }
        });
    </script>

@endsection