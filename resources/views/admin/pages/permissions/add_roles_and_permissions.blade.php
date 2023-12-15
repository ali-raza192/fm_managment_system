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
                    <form action="{{ route('store.role.and.permission') }}" method="POST">
                        @csrf
                        <select name="role_id" class="form-control">
                            <option value="">Please Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option> 
                            @endforeach
                        </select>
                        <hr>
                        @foreach ($permissionGroups as $permissionGroup)
                        @php
                            $permissions = App\Models\User::getPermissions($permissionGroup->group_name);
                        @endphp
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            {{ $permissionGroup->group_name }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" id="flexCheckChecked{{ $permission->id }}" name="permission_id[]">
                                            <label class="form-check-label" for="flexCheckChecked{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endforeach
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