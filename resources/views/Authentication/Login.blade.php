@extends('Templates.Plain')
@section('pageTitle','Login')

@section('content')
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h3">{{ getSettings('Nama') }}</a>
      </div>
      <div class="card-body">
        @if($message = \Session::get('info'))
          <div class="alert alert-primary" role="alert">
            {{ $message }}
          </div>
        @elseif($message = \Session::get('success'))
          <div class="alert alert-success" role="alert">
            {{ $message }}
          </div>
        @elseif($message = \Session::get('error'))
          <div class="alert alert-danger" role="alert">
            {{ $message }}
          </div>
        @elseif($message = \Session::get('warning'))
          <div class="alert alert-warning" role="alert">
            {{ $message }}
          </div>
        @else
          <p class="login-box-msg">Silahkan masuk untuk melanjutkan</p>
        @endif
        <form action="" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="Username" required autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="Password" required autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection