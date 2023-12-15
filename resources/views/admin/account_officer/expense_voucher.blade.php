@extends('admin.master_dashboard')
@section('main')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-12 align-self-center">
                <h3 class="text-themecolor mb-0">Approve Expense Voucher</h3>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Approve Expense Voucher</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <h4 class="card-title mb-0">Approve Expense Voucher</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered display" style="width: 100%">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>DDO Name</th>
                        <th>Expense Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Detail</th>
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
                    ajax: '{{ route('expense.vouchers.list.of.account.officer') }}',
                    columns: [
                    {data: 'id', name: 'id'},
                    {data: 'ddo_name', name: 'ddo_name'},
                    {data: 'expense_name', name: 'expense_name'},
                    {data: 'date', name: 'date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'detail', name: 'detail'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    
                    columnDefs: [
                    { targets: [0, 1, 2], searchable: true }
                    ]
                });
            }
            // Get Id of approve button
            $(document).on('click', '#approve-button', function(){
                var approveButtonId = $(this).data('approve-button-id');
                approveData(approveButtonId);
            });
            // send ajax request for Approve data
            function approveData(id) {
                swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to approve this Voucher!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approved!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: '/approve/expense/voucher/by/account/officer/' + id,
                        dataType: 'json',
                        success: function(response) {
                        Swal.fire(
                            'Approved!',
                            'Voucher Approved successfully!',
                            'success'
                        )
                        initializeDataTable();
                        },
                        error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'Error Approving Voucher. Please try again.',
                            'error'
                        )
                        }
                    });
                    } else {
                    Swal.fire(
                        'Cancel Approven',
                        'Voucher Approven cancelled.',
                        'success'
                    )
                    }
                });
            }

            // Get Id of reject button
            $(document).on('click', '#reject-button', function(){
                var rejectButtonId = $(this).data('reject-button-id');
                rejectData(rejectButtonId);
            });
            // send ajax request for reject data
            function rejectData(id) {
                swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to reject this Voucher!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Reject!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: '/reject/expense/voucher/by/account/officer/' + id,
                        dataType: 'json',
                        success: function(response) {
                        Swal.fire(
                            'Rejected!',
                            'Voucher Rejected successfully!',
                            'success'
                        )
                        initializeDataTable();
                        },
                        error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'Error Rejecting Voucher. Please try again.',
                            'error'
                        )
                        }
                    });
                    } else {
                    Swal.fire(
                        'Cancel Rejecting',
                        'Voucher Rejecting cancelled.',
                        'success'
                    )
                    }
                });
            }
        });
    </script>
@endsection 