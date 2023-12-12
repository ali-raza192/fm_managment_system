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
                <li class="breadcrumb-item active">Setting</li>
            </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-5">
              <div class="card">
                <div class="card-body">
                  <center class="mt-4">
                    <img src="{{ (!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo) : url('upload/no_image.jpg') }}" class="rounded-circle" width="150">
                    <h4 class="card-title mt-2">{{ $adminData->name }} {{ $adminData->last_name }} </h4>
                    <h6 class="card-subtitle">{{ $adminData->role }}</h6>
                    
                  </center>
                </div>
                <div>
                  <hr>
                </div>
                <div class="card-body">
                  <small class="text-muted">Email address </small>
                  <h6>{{ $adminData->email }}</h6>
                  @if ($adminData->phone == NULL)
                      
                  @else
                  <small class="text-muted pt-4 db">Phone</small>
                  <h6>{{ $adminData->phone }}</h6>
                  @endif
                  @if ($adminData->address == NULL)
                      
                  @else
                  <small class="text-muted pt-4 db">Address</small>
                  <h6>{{ $adminData->address }}</h6>
                  @endif
                  
                </div>
              </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
              <div class="card">
                <!-- Tabs -->
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-timeline-tab" data-bs-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Change Password</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">Delete Account</a>
                  </li>
                </ul>
                <!-- Tabs -->
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="post" action="{{ route('admin.password.store') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="col-md-12">
                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{session('status')}}
                                    </div>
                                    @elseif(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                      {{session('error')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                              <label for="example-email" class="col-md-12">Current Password</label>
                              <div class="col-md-12">
                                <input name="current_password" type="password" placeholder="Type Current Password" class="form-control form-control-line @error('current_password') is-invalid @enderror" id="current_password">
                              </div>
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="example-email" class="col-md-12">New Password</label>
                                <div class="col-md-12">
                                  <input name="new_password" id="new_password" type="password" placeholder="Type New Password" class="form-control form-control-line  @error('new_password') is-invalid @enderror">
                                </div>
                                @error('new_password')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="example-email" class="col-md-12">Confirm Password</label>
                                <div class="col-md-12">
                                  <input name="new_password_confirmation" id="new_password_confirmation" type="password" placeholder="Type Confirm Password" class="form-control form-control-line">
                                </div>
                                
                            </div>
                            
                            
                            <div class="mb-3">
                              <div class="col-sm-12">
                                <button class="btn btn-success">
                                  Change Password
                                </button>
                              </div>
                            </div>
                        </form>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                            <p class="text-sm">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                            </p>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="col-sm-12">
                          <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                            Delete Account
                          </button>
                        </div>
                      </div>
                      <div
                        class="modal fade"
                        id="bs-example-modal-lg"
                        tabindex="-1"
                        aria-labelledby="bs-example-modal-lg"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="myLargeModalLabel">
                                Are you sure you want to delete your account?
                              </h4>
                              <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                              ></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                                </p>
                                <form method="post" action="{{ route('profile.destroy') }}" class="form-horizontal form-material">
                                    @csrf
                                    @method('delete')
                                    <div class="mb-3">
                                        <label for="example-email" class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                          <input id="password"
                                          name="password"
                                          type="password" placeholder="Type Password" class="form-control form-control-line">
                                        </div>
                                        @if($errors->userDeletion->has('password'))
                                            <span class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</span>
                                        @endif
                                    </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">
                                    Delete Account
                                </button>
                                <button
                                    type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Column -->
          </div>
    </div>

@endsection
