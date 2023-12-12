@extends('admin.master_dashboard')
@section('main')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
      <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Dashboard</h3>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/dashboard') }}">Home</a>
          </li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
      <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
          <div class="d-flex me-3 ms-2">
            <div class="chart-text me-2">
              <h6 class="mb-0"><small>THIS MONTH</small></h6>
              <h4 class="mt-0 text-info">$58,356</h4>
            </div>
            <div class="spark-chart">
              <div id="monthchart"></div>
            </div>
          </div>
          <div class="d-flex ms-2">
            <div class="chart-text me-2">
              <h6 class="mb-0"><small>LAST MONTH</small></h6>
              <h4 class="mt-0 text-primary">$48,356</h4>
            </div>
            <div class="spark-chart">
              <div id="lastmonthchart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
          <div class="card bg-primary">
            <div class="card-body">
              <div class="d-flex">
                <div>
                  <h4 class="card-title text-white">Total Sales</h4>
                  <h6 class="card-subtitle text-white">$9432</h6>
                </div>
                <div class="ms-auto">
                  <button type="button" class="btn btn-primary dropdown-toggle p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-settings"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                  </div>
                </div>
              </div>
              <div id="spark4"><canvas width="242" height="50" style="display: inline-block; width: 242.3px; height: 50px; vertical-align: top;"></canvas></div>
            </div>
          </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
          <div class="card bg-info">
            <div class="card-body">
              <div class="d-flex">
                <div>
                  <h4 class="card-title text-white">Monthly Sales</h4>
                  <h6 class="card-subtitle text-white">$9432</h6>
                </div>
                <div class="ms-auto">
                  <button type="button" class="btn btn-info dropdown-toggle p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-settings"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                  </div>
                </div>
              </div>
              <div id="spark5"><canvas width="242" height="50" style="display: inline-block; width: 242.3px; height: 50px; vertical-align: top;"></canvas></div>
            </div>
          </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
          <div class="card bg-success">
            <div class="card-body">
              <div class="d-flex">
                <div>
                  <h4 class="card-title text-white">Weekly Sales</h4>
                  <h6 class="card-subtitle text-white">$9432</h6>
                </div>
                <div class="ms-auto">
                  <button type="button" class="btn btn-success dropdown-toggle p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-settings"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                  </div>
                </div>
              </div>
              <div id="spark6"><canvas width="242" height="50" style="display: inline-block; width: 242.3px; height: 50px; vertical-align: top;"></canvas></div>
            </div>
          </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
          <div class="card bg-warning">
            <div class="card-body">
              <div class="d-flex">
                <div>
                  <h4 class="card-title text-white">Daily Sales</h4>
                  <h6 class="card-subtitle text-white">$9432</h6>
                </div>
                <div class="ms-auto">
                  <button type="button" class="btn btn-warning dropdown-toggle p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-settings"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                    <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                  </div>
                </div>
              </div>
              <div id="spark7"><canvas width="242" height="50" style="display: inline-block; width: 242.3px; height: 50px; vertical-align: top;"></canvas></div>
            </div>
          </div>
        </div>
        <!-- Column -->
      </div>
    <!-- Row -->
    
    

    <div class="row">
    <div class="col-lg-12">
        <div class="card w-100">
        <div class="card-body">
            <div class="d-md-flex align-items-center">
            <div>
                <h4 class="card-title">Products Availability</h4>
                <h6 class="card-subtitle">March 2023</h6>
            </div>
            <div class="ms-auto">
                <select class="form-select">
                <option selected="">Electronics</option>
                <option value="1">Kitchen</option>
                <option value="2">Crocory</option>
                <option value="3">Wooden</option>
                </select>
            </div>
            </div>
            <div class="table-responsive">
            <table class="table stylish-table mt-4 no-wrap v-middle">
                <thead>
                <tr>
                    <th class="border-0 text-muted font-weight-medium" style="width: 90px">
                    Product
                    </th>
                    <th class="border-0 text-muted font-weight-medium">
                    Description
                    </th>
                    <th class="border-0 text-muted font-weight-medium">
                    Quantity
                    </th>
                    <th class="border-0 text-muted font-weight-medium">
                    Price
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                    <span class="
                        round
                        text-white
                        d-inline-block
                        text-center
                        rounded-circle
                        bg-info
                        "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart feather-sm"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>
                    </td>
                    <td>
                    <h6 class="mb-0 font-weight-medium">
                        <a href="javascript:void(0)" class="link">Apple iPhone 6 Space Grey, 16 GB</a>
                    </h6>
                    <small class="text-muted">Product id : MI5457
                    </small>
                    </td>
                    <td>
                    <h5>357</h5>
                    </td>
                    <td>
                    <h5>$435</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                    <span class="
                        round
                        text-white
                        d-inline-block
                        text-center
                        rounded-circle
                        bg-success
                        "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart feather-sm"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>
                    </td>
                    <td>
                    <h6 class="mb-0 font-weight-medium">
                        <a href="javascript:void(0)" class="link">Fossil Marshall For Men Black watch</a>
                    </h6>
                    <small class="text-muted">Product id : MI5457
                    </small>
                    </td>
                    <td>
                    <h5>357</h5>
                    </td>
                    <td>
                    <h5>$435</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                    <span class="
                        round
                        text-white
                        d-inline-block
                        text-center
                        rounded-circle
                        bg-danger
                        "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart feather-sm"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>
                    </td>
                    <td>
                    <h6 class="mb-0 font-weight-medium">
                        <a href="javascript:void(0)" class="link">Sony Bravia 80cm - 32 HD Ready LED TV</a>
                    </h6>
                    <small class="text-muted">Product id : MI5457
                    </small>
                    </td>
                    <td>
                    <h5>357</h5>
                    </td>
                    <td>
                    <h5>$435</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                    <span class="
                        round
                        text-white
                        d-inline-block
                        text-center
                        rounded-circle
                        bg-primary
                        "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart feather-sm"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>
                    </td>
                    <td>
                    <h6 class="mb-0 font-weight-medium">
                        <a href="javascript:void(0)" class="link">Panasonic P75 Champagne Gold, 8 GB</a>
                    </h6>
                    <small class="text-muted">Product id : MI5457
                    </small>
                    </td>
                    <td>
                    <h5>357</h5>
                    </td>
                    <td>
                    <h5>$435</h5>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
    </div>
    
  </div>
@endsection