<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta
      name="keywords"
      content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, material admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, material design, material dashboard bootstrap 5 dashboard template"
    />
    <meta
      name="description"
      content="MaterialPro is powerful and clean admin dashboard template, inpired from Google's Material Design"
    />
    <meta name="robots" content="noindex,nofollow" />
    <title>Admin Panel</title>
    <link
      rel="canonical"
      href="https://www.wrappixel.com/templates/materialpro/"
    />
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="{{ asset('admin/assets/images/favicon.png') }}"
    />
    
    <!-- Custom CSS -->
    <link href="{{ asset('admin/dist/css/style.min.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin/dist/libs/chartist/dist/chartist.min.css') }}">
    <link
      href="{{ asset('admin/dist/js/pages/chartist/chartist-init.css') }}"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('admin/dist/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}">
    
    <link rel="stylesheet" href="{{ asset('admin/dist/libs/c3/c3.min.css') }}">
    <!-- Toastr css-->
    <link href="{{ asset('admin/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- server-side dataTable css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 Css -->
    <link href="{{ asset('admin/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- select 2 css -->
    <link rel="stylesheet" href="{{ asset('admin/dist/libs/select2/dist/css/select2.min.css') }}">
  </head>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <svg
        class="tea lds-ripple"
        width="37"
        height="48"
        viewbox="0 0 37 48"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z"
          stroke="#1e88e5"
          stroke-width="2"
        ></path>
        <path
          d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34"
          stroke="#1e88e5"
          stroke-width="2"
        ></path>
        <path
          id="teabag"
          fill="#1e88e5"
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"
        ></path>
        <path
          id="steamL"
          d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke="#1e88e5"
        ></path>
        <path
          id="steamR"
          d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13"
          stroke="#1e88e5"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
      </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      @include('admin.body.header')
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      @include('admin.body.sidebar')
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        @yield('main')
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        @include('admin.body.footer')
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('admin/dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('admin/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/app.init.js') }}"></script>
    <script src="{{ asset('admin/dist/js/app-style-switcher.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('admin/dist/libs/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('admin/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('admin/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('admin/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <script src="{{ asset('admin/dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('admin/dist/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/echarts/dist/echarts.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jquery.flot/excanvas.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jquery.flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/c3/htdocs/js/d3-3.5.6.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/c3/htdocs/js/c3-0.4.9.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/gaugeJS/dist/gauge.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/pages/widget/widget-charts.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/pages/widget/card-custom.js') }}"></script>
    <!-- Toastr js -->
    <script src="{{ asset('admin/toastr/toastr.min.js') }}"></script>
    <script>
      @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}";
        var positionClass = 'toast-bottom-right';
        switch (type) {
          case 'info':
              toastr.info(" {{ Session::get('message') }} ");
              break;
          case 'success':
              toastr.success(" {{ Session::get('message') }} ");
              break;
          case 'warning':
              toastr.warning(" {{ Session::get('message') }} ");
              break;
          case 'error':
              toastr.error(" {{ Session::get('message') }} ");
              break;
        }
      @endif
   </script>   
  {{-- server-side dataTable  --}}
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <!-- jquery-validation -->
  <script src="{{ asset('admin/jquery-validation/validate.min.js') }}"></script>
  <script src="{{ asset('admin/jquery-validation/index.js') }}"></script>
  <!-- SweetAlert2 js -->
  <script src="{{ asset('admin/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- select 2 -->
  <script src="{{ asset('admin/dist/libs/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('admin/dist/libs/select2/dist/js/select2.min.js') }}"></script>
  <script src="{{ asset('admin/dist/js/pages/forms/select2/select2.init.js') }}"></script>
  <script>
    ddoDataForInsert();
    function ddoDataForInsert(){
      $.ajax({
        url: '/ddo/data/for/update',
        type: 'GET',
        dataType: 'json',
        success: function(response){
          // console.log(response);
          $('select[name="ddo_id[]"]').html('');
          var d = $('select[name="ddo_id[]"]').empty();
          $('select[name="ddo_id[]"]').append('<option value="">Please Select DDO</option>');
          $.each(response, function(key, value) {
            $('select[name="ddo_id[]"]').append('<option value="' + value.id + '">' + value.name + ' ' + value.last_name + '</option>');
          });
        }
      });
    }
    ddoDataForUpdate();
    function ddoDataForUpdate(){
      $.ajax({
        url: '/ddo/data/for/update',
        type: 'GET',
        dataType: 'json',
        success: function(response){
          // console.log(response);
          $('select[name="uDdo_id[]"]').html('');
          var d = $('select[name="uDdo_id[]"]').empty();
          $('select[name="uDdo_id[]"]').append('<option value="">Please Select DDO</option>');
          $.each(response, function(key, value) {
            $('select[name="uDdo_id[]"]').append('<option value="' + value.id + '">' + value.name + ' ' + value.last_name + '</option>');
          });
        }
      });
    }
    function displayPreviousDdoToAccountantData() {
      var uId = $("#accountant_id").val();
      // alert($uId);
      $.ajax({
        type: 'GET',
        url: '/display/previous-data/ddo-to-accountant',
        data: {
          uid : uId,
        },
        dataType: 'json',
        success: function(data) {
         
          // console.log(data);
          var ddoData = "";
          $.each(data, function(key, value) {
            ddoData += `<tr id="uDelete_add_more_items">
              <td>
                <input type="text" disabled class="form-control" name="" value="${value.ddo_name.name +' '+ value.ddo_name.last_name}">
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" id="${value.ddo_id}" onclick="deleteDdo(this.id)"><i class="mdi mdi-close-box-outline"></i></button>
              </td>
            </tr>`
          }); /// End foreach Loop
          $("#addDDOData").html(ddoData);
        } /// End Success Function
        }); /// End Ajax Request
    } /// End Function

    function deleteDdo(id){
      // alert(id);
      var dId = id;
      $.ajax({
        url: '/delete/ddo-that-assigned-to-accountant',
        type: 'GET',
        dataType: 'json',
        data: {
          dId: dId
        },
        success: function (response){
          ddoDataForUpdate();
          ddoDataForInsert();
          // console.log(response);
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          })
          if ($.isEmptyObject(response.error)) {
            Toast.fire({
              type: 'success',
              icon: 'success',
              title: response.success,
            })
          } else {
            Toast.fire({
              type: 'error',
              icon: 'error',
              title: response.error,
            })
          }
          displayPreviousDdoToAccountantData();
        }
      });
    }
  </script>
  </body>
</html>