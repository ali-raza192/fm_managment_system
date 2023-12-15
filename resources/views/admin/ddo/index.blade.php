@extends('admin.master_dashboard')
@section('main')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-12 align-self-center">
                <h3 class="text-themecolor mb-0">Create Expense Voucher</h3>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Create Expense Voucher</li>
                </ol>
            </div>
        </div>
        <!-- multi-column ordering -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0" style="float: left;">Available Budget</h4>
                        @if (optional($budget)->total > 0)
                            <h3 class="card-title mb-0" style="float: right;">RS {{ optional($budget)->total }}</h3> 
                        @else
                            <h3 class="card-title mb-0" style="float: right;">RS 0</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <h4 class="card-title mb-0" style="float: left;">List of Expenses</h4>
                    @if (optional($budget)->total > 0)
                        <h4 class="card-title mb-0" style="float: right;"><button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#bs-add-modal">Add</button></h4>
                    @else
                        
                    @endif
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered display" style="width: 100%">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>Expense Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
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

    <!-----------------------------------------Create Modal -------------------------------------- -->

    @include('admin.ddo.partials.create')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            var dataTable;

            initializeDataTable();

            function initializeDataTable() {
                if ($.fn.DataTable.isDataTable('#dataTable')) {
                    $('#dataTable').DataTable().destroy();
                }

                dataTable = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('expense.vouchers.list') }}',
                    columns: [
                    {data: 'id', name: 'id'},
                    {data: 'expense_name', name: 'expense_name'},
                    {data: 'date', name: 'date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'status', name: 'status'},
                    ],
                    
                    columnDefs: [
                    { targets: [0, 1, 2], searchable: true }
                    ]
                });
            }
            // validate add form input feilds
            $('#myForm').validate({
                rules: {
                    expense: {
                        required: true,
                    },
                    amount: {
                        required: true,
                        number: true,
                    },
                },
                messages: {
                    expense: {
                        required: 'Please select Expense',
                    },
                    amount: {
                        required: 'Please Enter Expense Amount',
                        number: 'Please Enter only numbers',
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
                        url: '{{ route('create.expense.voucher') }}',
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

        });
    </script>
@endsection