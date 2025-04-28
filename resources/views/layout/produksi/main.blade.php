
<!DOCTYPE html>
<html lang="en">
  <head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="apple-touch-icon" sizes="76x76" href="{{asset('vendor')}}/assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}">

<title>
@yield('title')
</title>

<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

<!-- Nucleo Icons -->
<link href="{{asset('vendor')}}/assets/css/nucleo-icons.css" rel="stylesheet" />
<link href="{{asset('vendor')}}/assets/css/nucleo-svg.css" rel="stylesheet" />

<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- CSS Files -->

<link id="pagestyle" href="{{asset('vendor')}}/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />

  </head>


  <body class="g-sidenav-show  bg-gray-100">

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
@if (Auth::user()->role == 0)
  @include('layout.pengadaan.sidebar')
@elseif (Auth::user()->role == 1)
  @include('layout.produksi.sidebar')
@elseif (Auth::user()->role == 2)
  @include('layout.direktur.sidebar')
@elseif (Auth::user()->role == 3)
  @include('layout.penjualan.sidebar')

@endif
  
</aside>

      <main class="main-content border-radius-lg ">
        <!-- Navbar -->

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
  @include('layout.produksi.topbar')
</nav>

<!-- End Navbar -->
            <div class="container-fluid py-4">
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
@yield('content')

<footer class="footer py-4  ">
 @include('layout.produksi.footer')
</footer>
            </div>
       </main>
</div>

      
      















<!--   Core JS Files   -->
<script src="{{asset('vendor')}}/assets/js/core/popper.min.js" ></script>
<script src="{{asset('vendor')}}/assets/js/core/bootstrap.min.js" ></script>
<script src="{{asset('vendor')}}/assets/js/plugins/perfect-scrollbar.min.js" ></script>
<script src="{{asset('vendor')}}/assets/js/plugins/smooth-scrollbar.min.js" ></script>











































































<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc --><script src="{{asset('vendor')}}/assets/js/material-dashboard.min.js?v=3.1.0"></script>
  </body>

</html>
