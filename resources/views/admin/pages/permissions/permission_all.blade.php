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
        <!-- multi-column ordering -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="border-bottom title-part-padding">
                  <h4 class="card-title mb-0">Craete Accounts</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.permission') }}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">
                            <label for="example-email" class="col-md-12">Permission Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="Permission Name">
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <label for="example-email" class="col-md-12">Group Name</label>
                            <div class="col-md-12">
                                <select name="group_name" class="form-control">
                                    <option value="deputy director finance">Deputy Director Finance</option>
                                    <option value="account officer">Account Officer</option>
                                    <option value="assistant accountant">Assistant Accountant</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="DDO">DDO</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button class="btn btn-success" type="submit">Submit Form</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection