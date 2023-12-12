@extends('admin.master_dashboard')
@section('main')
  <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
      <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Approve DDO</h3>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/dashboard') }}">Home</a>
          </li>
          <li class="breadcrumb-item active">Approve DDO</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="border-bottom title-part-padding">
            <h4 class="card-title mb-0">Approve DDO</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="dataTable" class="table table-striped table-bordered display" style="width: 100%">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Accountant</th>
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

  {{-- ----------------------------------------------Update Modal ------------------------------------------------ --}}

  @include('admin.deputy_director_finance.approve_ddo_assign_to_accountant.partials.view')

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
          ajax: '{{ route('deputy.director.approve.ddo') }}',
          columns: [
            {data: 'id', name: 'id'},
            {data: 'accountant_name', name: 'accountant_name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          
          columnDefs: [
            { targets: [0, 1, 2], searchable: true }
          ]
        });
      }

      $(document).on('click', '#status-button', function (){
        var changeStatusButton = $(this).data('status-button-id');
        changeStatus(changeStatusButton);
      });

      function changeStatus(id){
        // alert(id);
        $.ajax({
          type: 'GET',
          url: '/status/approve/ddo/' + id,
          dataType: 'json',
          success: function(data) {
            initializeDataTable();
            // console.log(data);
          }    
        });
      }

      // Get Id of edit button
      $(document).on('click', '#view-button', function(){
        var viewButtonId = $(this).data('view-button-id');
        viewData(viewButtonId);
      });
      // show data in users modal
      function viewData(id) {
        // alert(id);
        $.ajax({
          type: 'GET',
          url: '/ddo-to-accountant/edit/data/' + id,
          dataType: 'json',
          success: function(data) {
            // console.log(data);
            $("#accountant_id").val(data.editData.accountant_id);
            $("#uAccountant").val(data.editData.accountant_id).trigger('change');
            displayPreviousDdoToAccountantData();
          }    
        });
      }
    });
  </script>
@endsection