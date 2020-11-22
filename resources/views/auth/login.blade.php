@extends('auth.master')

@section('title', 'Beranda')

@section('css-lib')
<link rel="stylesheet" href="{{ URL::asset('node_modules/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
@endsection

@section('main-content')
<div class="row">
  <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
    <div class="login-brand">
      <img src="{{ URL::asset('images/logo120px.png') }}" alt="logo" width="100" class="shadow-light rounded-circle">
    </div>

    @include('flash_message')

    <div class="card card-primary">
      <div class="card-header">
        <h4>Login</h4>
      </div>

      <div class="card-body">
        <form action="{{ route('login') }}" method="post">
          @csrf

          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="text" class="form-control @if($errors->has('email')){{ "is-invalid" }}@endif"
              name="email" value="{{ old('email') }}">
            <span class="text-danger d-inline"><small><i>{{ $errors->first('email') }}</i></small></span>
          </div>

          <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <div class="float-right">
              <a href="auth-forgot-password.html" class="text-small">
                Lupa password?
              </a>
            </div>
            <input id="password" type="password"
              class="form-control pwstrength @if($errors->has('password')){{ "is-invalid" }}@endif"
              data-indicator="pwindicator" name="password">
            <span class="text-danger d-inline"><small><i>{{ $errors->first('password') }}</i></small></span>
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="setuju"
                class="custom-control-input @if($errors->has('setuju')){{ "is-invalid" }}@endif" id="setuju"
                @if(empty($errors->has('setuju'))){{ "checked" }}@endif>
              <label class="custom-control-label" for="setuju">Ingat saya {{ $errors->first('setuju') }}</label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="mt-5 text-muted text-center">
      Belum memiliki akun? <a href="{{ url('register') }}">Buat Akun</a>
    </div>
    <div class="simple-footer">
      Madinatul Quran - Jonggol &copy; 2020
    </div>
  </div>
  @endsection

  @section('js-lib')
  <script src="{{ URL::asset('node_modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
  <script src="{{ URL::asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
  <script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}">
  </script>
  <script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js') }}">
  </script>
  @endsection

  @section('js-specific')
  @endsection

  </html>