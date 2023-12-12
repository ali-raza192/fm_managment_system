@extends('admin.master_dashboard')
@section('main')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Chart Of Accounts</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Chart Of Accounts</li>
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
                <h4 class="card-title mb-0" style="float: left;">Chart Of Accounts</h4>
                <h4 class="card-title mb-0" style="float: right;"><a href="{{ route('add.chart.of.accounts') }}" class="btn btn-success">Add</a></h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered display" style="width: 100%">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>DDO</th>
                        <th>Date</th>
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
        $(document).ready(function() {
            var dataTable;

            initializeDataTable();

            function initializeDataTable() {
                if ($.fn.DataTable.isDataTable('#dataTable')) {
                    $('#dataTable').DataTable().destroy();
                }

                dataTable = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('chart.of.accounts.list') }}',
                    columns: [
                    {data: 'id', name: 'id'},
                    {data: 'ddo_name', name: 'ddo_name'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    
                    columnDefs: [
                    { targets: [0, 1, 2], searchable: true }
                    ]
                });
            }
            // Get Id of delete button
            $(document).on('click', '#delete-button', function(){
                var deleteButtonId = $(this).data('delete-button-id');
                deleteData(deleteButtonId);
            });
            // send ajax request for delete data
            function deleteData(id) {
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this chart!",
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
                            url: '/delete-data-of-chart-of-account/' + id,
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