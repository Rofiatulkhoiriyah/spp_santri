<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('pageTitle')</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="shortcut icon" href="{{ asset(getSettings('Logo')) }}">
  <style>
    #loading-state {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 9999;
        width: 100vw;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.5);
        background-image: url("{{ asset('assets/images/loader.gif') }}");
        background-size: 10%;
        background-repeat: no-repeat;
        background-position: center;
    }
  </style>
  @yield('extraCss')

  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
  @yield('extraJs')
</head>
<body class="hold-transition sidebar-mini">
<div id="loading-state"></div>
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="/profile">
          <i class="fas fa-user"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/auth/signout">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
      <img src="{{ asset(getSettings('Logo')) }}" class="brand-image">
      <span class="brand-text font-weight-light" style="font-size: 12pt">{{ getSettings('Nama') }}</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <img src="{{ asset('assets/images/nophoto.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/profile" class="d-block">{{ \Auth::user()->Nama }}</a>
          <span class="text-muted">{{ (strtoupper(\Auth::user()->Role) == 'USER') ? 'SANTRI' : 'ADMIN' }}</span>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @php
              $module = explode('/',$_SERVER['REQUEST_URI']);
              $module = end($module);
              $module = explode('?',$module)[0];
          @endphp
          <li class="nav-header">Dashboard</li>
          <li class="nav-item">
            <a href="/" class="nav-link {{ (!$module) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          @if(\Auth::user()->Role == 'admin') <li class="nav-header">Pengaturan Aplikasi</li> @endif
          <li class="nav-item">
            <a href="/setting" class="nav-link {{ ($module == 'setting') ? 'active' : '' }}">
              <i class="nav-icon fas fa-landmark"></i>
              <p>Profil Lembaga</p>
            </a>
          </li>
          @if(\Auth::user()->Role == 'admin') 
            <li class="nav-item {{ ($module == 'galeri' || $module == 'pengumuman') ? 'menu-is-opening menu-open' : '' }}">
              <a href="#" class="nav-link {{ ($module == 'galeri' || $module == 'pengumuman') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Pengaturan Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/setting/pengumuman" class="nav-link {{ ($module == 'pengumuman') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pengumuman</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/setting/galeri" class="nav-link {{ ($module == 'galeri') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Galeri</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          <li class="nav-header">Santri</li>
          <li class="nav-item">
            <a href="/santri" class="nav-link {{ ($module == 'santri') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Data Santri</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/santri/tagihan" class="nav-link {{ ($module == 'tagihan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-receipt"></i>
              <p>Tagihan Santri</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/santri/hafalan" class="nav-link {{ ($module == 'hafalan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-quran"></i>
              <p>Hafalan Santri</p>
            </a>
          </li>
          <li class="nav-header">Akun</li>
          <li class="nav-item">
            <a href="/pengguna" class="nav-link {{ ($module == 'pengguna') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>Pengguna</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">@yield('pageTitle')</h1>
            <h6>@yield('pageSubtitle')</h6>
          </div>
        </div>
      </div>
    </div>
    
    <div class="content">
      <div class="container-fluid">
        @if($message = \Session::get('info'))
          <div class="alert alert-primary" role="alert">
            {!! $message !!}
          </div>
        @elseif($message = \Session::get('success'))
          <div class="alert alert-success" role="alert">
            {!! $message !!}
          </div>
        @elseif($message = \Session::get('error'))
          <div class="alert alert-danger" role="alert">
            {!! $message !!}
          </div>
        @elseif($message = \Session::get('warning'))
          <div class="alert alert-warning" role="alert">
            {!! $message !!}
          </div>
        @endif
        @yield('content')
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      {{ getSettings('Nama') }}
    </div>
  </footer>
</div>

<script>
  $(function(){
    $("#loading-state").css("display","none")
  })
  function confirmAlert(href) {
    Swal.fire({
      icon: 'question',
      title: 'Apakah anda yakin untuk melanjutkan?',
      showCancelButton: true,
      confirmButtonText: 'Ya, Lanjutkan',
      denyButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = href
      }
    })
  }

  $(".dtpicker").datepicker({
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    yearRange: '1950:{{ \Carbon\Carbon::now()->format("Y") }}'
  })

  $(".dtrange").daterangepicker({
    autoUpdateInput: false,
    locale: {
      format: 'DD/M/YYYY'
    }
  })

  $(".dtrange").on("apply.daterangepicker", function(ev, picker) {
      $(this).val(picker.startDate.format("DD/M/YYYY") + " - " + picker.endDate.format("DD/M/YYYY"));
  });

  $(".dtrange").on("cancel.daterangepicker", function(ev, picker) {
      $(this).val("");
  });
</script>
@yield('customJs')
</body>
</html>
