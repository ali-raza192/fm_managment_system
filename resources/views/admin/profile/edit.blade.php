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
                <li class="breadcrumb-item active">Profile</li>
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
                    <a class="nav-link active" id="pills-timeline-tab" data-bs-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Profile Information</a>
                  </li>
                </ul>
                <!-- Tabs -->
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="post" action="{{ route('admin.profile.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                              <div class="row">
                                <div class="col-md-6">
                                    <label class="">First Name</label>
                                    <div class="">
                                        <input name="name" type="text" value="{{ $adminData->name }}" required placeholder="Johnathan Doe" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="">Last Name</label>
                                    <div class="">
                                        <input name="last_name" type="text" value="{{ $adminData->last_name }}" placeholder="Johnathan Doe" class="form-control form-control-line">
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="mb-3">
                              <label for="example-email" class="col-md-12">Email</label>
                              <div class="col-md-12">
                                <input name="email" type="email" value="{{ $adminData->email }}" placeholder="johnathan@admin.com" class="form-control form-control-line">
                              </div>
                            </div>
                            <div class="mb-3">
                                <label class="col-md-12">Phone No</label>
                                <div class="col-md-12">
                                  <input name="phone" type="text" value="{{ $adminData->phone }}" placeholder="123 456 7890" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="example-email" class="col-md-12">Address</label>
                                <div class="col-md-12">
                                    <textarea name="address" rows="5" class="form-control form-control-line">{{ $adminData->address }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                              <label class="col-md-12">Photo</label>
                              <div class="col-md-12">
                                <input type="file" name="photo" class="form-control" id="image">
                              </div>
                            </div>
                        
                            <div class="mb-3">
                                <label class="col-md-12"></label>
                                <div class="col-sm-9 text-secondary">
                                    <img id="showImage" src="{{ (!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo) : url('upload/no_image.jpg') }}" alt="Admin" style="width:100px;height: 100px;">
                                </div>
                            </div>
                            
                            
                            <div class="mb-3">
                              <div class="col-sm-12">
                                <button class="btn btn-success">
                                  Save
                                </button>
                              </div>
                            </div>
                        </form>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- Column -->
          </div>
    </div>

<script src="{{ asset('admin/jquery/jquery.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endsection
