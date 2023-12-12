<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, material pro admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, material design, material dashboard bootstrap 5 dashboard template"
    />
    <meta
      name="description"
      content="Material Pro is powerful and clean admin dashboard template"
    />
    <meta name="robots" content="noindex,nofollow" />
    <title>Material Pro Template by WrapPixel</title>
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="main-wrapper">
      <!-- -------------------------------------------------------------- -->
      <!-- Login box.scss -->
      <!-- -------------------------------------------------------------- -->
      <div
        class="
          auth-wrapper
          d-flex
          no-block
          justify-content-center
          align-items-center
        "
        style="background: url('{{ asset('admin/assets/images/background/login-register.jpg') }}') no-repeat center center; background-size: cover;"
      >
        <div class="auth-box p-4 bg-white rounded">
          <div id="loginform">
            <div class="logo">
              <h3 class="box-title mb-3">Sign In</h3>
            </div>
            <!-- Form -->
            <div class="row">
              <div class="col-12">
                <form
                  class="form-horizontal mt-3 form-material"
                  method="POST" action="{{ route('login') }}"
                >
                    @csrf
                  <div class="form-group mb-3">
                    <div class="">
                      <input
                        class="form-control"
                        type="email"
                        required=""
                        placeholder="Username"
                        id="email"
                        name="email"
                      />
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group mb-4">
                    <div class="">
                      <input
                        class="form-control"
                        type="password"
                        required=""
                        placeholder="Password"
                        id="password"
                        name="password"
                      />
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <div class="d-flex">
                      <div class="checkbox checkbox-info pt-0">
                        <input
                          id="remember_me"
                          type="checkbox"
                          class="material-inputs chk-col-indigo"
                          name="remember_me"
                        />
                        <label for="remember_me"> Remember me </label>
                      </div>
                      <div class="ms-auto">
                        @if (Route::has('password.request'))
                        <a
                          href="{{ route('password.request') }}"
                          id="to-recover"
                          class="link font-weight-medium"
                          ><i class="fa fa-lock me-1"></i> Forgot pwd?</a
                        >
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="form-group text-center mt-4 mb-3">
                    <div class="col-xs-12">
                      <button
                        class="
                          btn btn-info
                          d-block
                          w-100
                          waves-effect waves-light
                        "
                        type="submit"
                      >
                        Log In
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- -------------------------------------------------------------- -->
      <!-- Login box.scss -->
      <!-- -------------------------------------------------------------- -->
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- All Required js -->
    <!-- -------------------------------------------------------------- -->
    <script src="{{ asset('admin/dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('admin/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- -------------------------------------------------------------- -->

  </body>
</html>
