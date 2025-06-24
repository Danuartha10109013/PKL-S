<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('vendor')}}/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}">
  <title>Login || PT. Bersama Sahabat Makmur</title>

  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link href="{{asset('vendor')}}/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{asset('vendor')}}/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="{{asset('vendor')}}/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <!-- SweetAlert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">

  <main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                  <div class="row mt-3">
                    <div class="col-2"></div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">

                      <img class="position-center"  src="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}" width="300%" alt="Logo PT. BSM">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2"></div>
                    {{-- <div class="col-2 text-center ms-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-facebook text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center px-1">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-github text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center me-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-google text-white text-lg"></i>
                      </a>
                    </div> --}}
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form action="{{route('login-proses')}}" method="POST" role="form" class="text-start">
                  @csrf
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Username Or Email</label>
                    <input type="text" name="username" class="form-control">
                  </div>
                  <div class="input-group input-group-outline my-3 position-relative">
                    <label class="form-label" for="passwordInput">Password</label>
                    <input type="password" name="password" class="form-control pr-5" id="passwordInput">
                    
                    <!-- Toggle icon positioned absolutely -->
                    <span onclick="togglePasswordVisibility()" style="position: absolute; top: 10px; right: 15px; cursor: pointer;">
                      <i class="fas fa-eye" id="toggleIcon"></i>
                    </span>
                  </div>

                  <script>
                    function togglePasswordVisibility() {
                      const passwordInput = document.getElementById("passwordInput");
                      const toggleIcon = document.getElementById("toggleIcon");
                      if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        toggleIcon.classList.remove("fa-eye");
                        toggleIcon.classList.add("fa-eye-slash");
                      } else {
                        passwordInput.type = "password";
                        toggleIcon.classList.remove("fa-eye-slash");
                        toggleIcon.classList.add("fa-eye");
                      }
                    }
                  </script>


                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Core JS Files -->
  <script src="{{asset('vendor')}}/assets/js/core/popper.min.js"></script>
  <script src="{{asset('vendor')}}/assets/js/core/bootstrap.min.js"></script>
  <script src="{{asset('vendor')}}/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{asset('vendor')}}/assets/js/plugins/smooth-scrollbar.min.js"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    document.addEventListener('DOMContentLoaded', function () {
      @if (session('success'))
        Swal.fire({
          title: '{{ session('success') }}',
          icon: 'success',
          confirmButtonColor: '#007bff', // Set button color to blue
        });
      @endif

      @if (session('failed'))
        Swal.fire({
          title: '{{ session('failed') }}',
          icon: 'error',
          confirmButtonColor: '#007bff', // Set button color to blue
        });
      @endif
    });
  </script>

  <!-- Control Center for Material Dashboard -->
  <script src="{{asset('vendor')}}/assets/js/material-dashboard.min.js?v=3.1.0"></script>

</body>

</html>
