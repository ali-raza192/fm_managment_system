@extends('admin.master_dashboard')
@section('main')
  <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Assign DDOs To Accountant</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
            <a href="{{ url('/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Assign DDOs To Accountant</li>
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
              <h4 class="card-title mb-0" style="float: left;">Assign DDOs</h4>
              <h4 class="card-title mb-0" style="float: right;"><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bs-add-modal">Add</button></h4>
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

  {{-- ----------------------------------------------Add Modal ------------------------------------------------ --}}

  @include('admin.account_officer.assign_ddo_to_accountant.partials.create')

  {{-- ----------------------------------------------Update Modal ------------------------------------------------ --}}

  @include('admin.account_officer.assign_ddo_to_accountant.partials.update')


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
        ajax: '{{ route('approve.ddo.list') }}',
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
    // apply select2 for modals
    $(".select2").select2({
      dropdownParent: $("#bs-add-modal")
    });

    // $(".select2").select2({
    //   dropdownParent: $("#bs-update-modal")
    // });

    $(document).on('change', 'select[name="ddo_id[]"]', function() {
      var selectedDDO = $(this).val();

      // Check if the selected DDO is not empty and is not already selected
      if (selectedDDO !== "" && isDDOSelected(selectedDDO, this)) {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        })
        Toast.fire({
          type: 'error',
          icon: 'error',
          title: "This DDO ia already selected. Please select a different DDO.",
        })
        $(this).val($(this).data('previous-value')).trigger('change');
      } else {
        $(this).data('previous-value', selectedDDO);
      }
    });

    $(document).on('click', '#addEvent', function() {
      ddoDataForInsert();
      var html = '';
      html += `<tr id="delete_add_more_items">
        <td>
          <select class="form-control" name="ddo_id[]">
            
          </select>
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm" id="removerow"><i class="mdi mdi-minus-circle-outline"></i></button>
        </td>
      </tr>`;
      $("#appendData").append(html);
    });

    // Function to check if the DDO is already selected in existing rows
    function isDDOSelected(selectedDDO, currentSelect) {
      var isAlreadySelected = false;
      $('select[name="ddo_id[]"]').not(currentSelect).each(function() {
        if ($(this).val() === selectedDDO) {
          isAlreadySelected = true;
          return false; // Exit the loop early since the DDO is already selected
        }
      });
      return isAlreadySelected;
    }
    $(document).on("click", "#removerow", function(e) {
      $(this).closest("#delete_add_more_items").remove();
    });
    // validate assign ddos form input feilds
    $('#myForm').validate({
      rules: {
        accountant: {
          required: true,
        },
        'ddo_id[]': {
          required: true,
        },
      },
      messages: {
        accountant: {
          required: 'Please select accountant',
        },
        'ddo_id[]': {
          required: 'Please select ddo',
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
    $("#addAssignButton").click(function(e) {
      e.preventDefault();
      if ($("#myForm").valid()) {
        var formData = new FormData($('#myForm')[0]);
        $.ajax({
          url: '{{ route('create.assigned') }}',
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
              $('#accountant').val(null).trigger('change.select2');
              $("#myForm")[0].reset();
              $("#closeAddModal").click();
              initializeDataTable();
              ddoDataForInsert();
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

    // ------------- update or edit functionalities start here -------------------------- //

    // Get Id of edit button
    $(document).on('click', '#edit-button', function(){
      var editButtonId = $(this).data('edit-button-id');
      updateData(editButtonId);
      displayUpdateButton();
    });
    // show data in users modal
    function updateData(id) {
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

    $(document).on('change', 'select[name="uDdo_id[]"]', function() {
      var selectedDDO1 = $(this).val();

      // Check if the selected DDO is not empty and is not already selected
      if (selectedDDO1 !== "" && isDDOSelected1(selectedDDO1, this)) {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        })
        Toast.fire({
          type: 'error',
          icon: 'error',
          title: "This DDO ia already selected. Please select a different DDO.",
        })
        $(this).val($(this).data('previous-value')).trigger('change');
      } else {
        $(this).data('previous-value', selectedDDO1);
      }
    });

    $(document).on('click', '#uAddEvent', function() {
      ddoDataForUpdate();
      var html = '';
      html += `<tr id="uDelete_add_more_items">
        <td>
          <select class="form-control" name="uDdo_id[]">
                                        
          </select>
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm" id="uRemoverow"><i class="mdi mdi-minus-circle-outline"></i></button>
        </td>
      </tr>`;
      $("#addDDOData").append(html);
    });
    // Function to check if the DDO is already selected in existing rows
    function isDDOSelected1(selectedDDO1, currentSelect1) {
      var isAlreadySelected1 = false;
      $('select[name="uDdo_id[]"]').not(currentSelect1).each(function() {
        if ($(this).val() === selectedDDO1) {
          isAlreadySelected1 = true;
          return false; // Exit the loop early since the DDO is already selected
        }
      });
      return isAlreadySelected1;
    }
    $(document).on("click", "#uRemoverow", function(e) {
      $(this).closest("#uDelete_add_more_items").remove();
    });
    
    displayUpdateButton();
    function displayUpdateButton() {
      $(document).on('change', 'select[name="uDdo_id[]"]', function(){
        var anySelected = $('select[name="uDdo_id[]"]').filter(function () {
          return this.value !== "";
        }).length > 0;
        if (anySelected) {
          $(".display-button").show();
        } else {
          $(".display-button").hide();
        }
      });
    }

    // send ajax request for update data
    $("#updateButton").click(function(e){
      e.preventDefault();
      var formData = new FormData($('#updateForm')[0]);
      $.ajax({
        url: '{{ route('update.data.ddo.to.accountant') }}',
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
            ddoDataForUpdate();
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
      deleteData(deleteButtonId);
    });
    // send ajax request for delete data
    function deleteData(id) {
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
            url: '/delete-data-ddo-to-accountant/' + id,
            dataType: 'json',
            success: function(response) {
              Swal.fire(
                'Deleted!',
                'User deleted successfully!',
                'success'
              )
              initializeDataTable();
              ddoDataForUpdate();
              ddoDataForInsert();
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