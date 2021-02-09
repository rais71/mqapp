@extends('auth.master')

@section('title', 'Beranda')

@section('css-lib')
<link rel="stylesheet" href="{{ URL::asset('node_modules/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
@endsection

@section('main-content')
<div class="row">
  <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
    <div class="login-brand">
      <img src="{{ URL::asset('images/logo150px.png') }}" alt="logo" width="100" class="shadow-light rounded-circle">
    </div>

    @include('flash_message')

    <div class="card card-primary">
      <div class="card-header">
        <h4>Daftar Akun</h4>
      </div>

      <div class="card-body">
        <form action="{{ route('register') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="nama-santri">Nama Lengkap Santri</label>
            <input id="nama-santri" type="text" value="{{ old('nama-santri') }}"
              class="form-control  @if($errors->has('nama-santri')){{ "is-invalid" }}@endif" name="nama-santri"
              autofocus>
            <small id="passwordHelpBlock" class="form-text text-muted d-inline">
              Mohon diisi sesuai dengan ijazah / KTP.
            </small>
            <span class="text-danger d-inline"><small><i>{{ $errors->first('nama-santri') }}</i></small></span>
          </div>

          <div class="row">
            <div class="form-group col-6">
              <label for="first_name">Tanggal Lahir Santri</label>
              <input class="form-control datepicker @if($errors->has('tgl-lahir-santri')){{ "is-invalid" }}@endif"
                type="text" id="tgl-lahir-santri" name="tgl-lahir-santri" value="{{ old('tgl-lahir-santri') }}"
                autocomplete="off">
              <span class="text-danger d-inline"><small><i>{{ $errors->first('tgl-lahir-santri') }}</i></small></span>
            </div>
            <div class="form-group col-6">
              <label for="nama-ibu">Nama Ibu Kandung</label>
              <input id="nama-ibu" type="text"
                class="form-control  @if($errors->has('nama-ibu')){{ "is-invalid" }}@endif" name="nama-ibu"
                value="{{ old('nama-ibu') }}">
              <span class="text-danger d-inline"><small><i>{{ $errors->first('nama-ibu') }}</i></small></span>
            </div>
          </div>

          <div class="form-divider">
            Buat Informasi Login
            <p class="text-muted">Email & Password yang anda isi dibawah akan digunakan untuk masuk kedalam akun anda.
              Harap di ingat baik-baik, catat jika perlu.</p>
          </div>

          <div class="form-group">
            <label for="email">Email Aktif</label>
            <input id="email" type="text" class="form-control @if($errors->has('email')){{ "is-invalid" }}@endif"
              name="email" value="{{ old('email') }}">
            <small id="passwordHelpBlock" class="form-text text-muted d-inline">
              Mohon gunakan Email aktif. Email akan digunakan untuk login dan reset password anda jika lupa.
            </small>
            <span class="text-danger d-inline"><small><i>{{ $errors->first('email') }}</i></small></span>
          </div>

          <div class="row">
            <div class="form-group col-6">
              <label for="password" class="d-block">Password</label>
              <input id="password" type="password"
                class="form-control pwstrength @if($errors->has('password')){{ "is-invalid" }}@endif"
                data-indicator="pwindicator" name="password">
              {{-- <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
              </div> --}}
              <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                Gunakan password dengan gabungan angka dan huruf.
              </small>
              <span class="text-danger d-inline"><small><i>{{ $errors->first('password') }}</i></small></span>
            </div>
            <div class="form-group col-6">
              <label for="password2" class="d-block">Ulangi Password</label>
              <input id="password2" type="password"
                class="form-control @if($errors->has('password2')){{ "is-invalid" }}@endif" name="password2">
              <span class="text-danger d-inline"><small><i>{{ $errors->first('password2') }}</i></small></span>
            </div>
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="setuju"
                class="custom-control-input @if($errors->has('setuju')){{ "is-invalid" }}@endif" id="setuju"
                @if(empty($errors->has('setuju'))){{ "checked" }}@endif>
              <label class="custom-control-label" for="setuju">Saya setuju dengan syarat dan ketentuan Pondok Pesantren
                Madinatul Qur'an. {{ $errors->first('setuju') }}</label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">
              Daftar
            </button>
          </div>
        </form>
      </div>
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
  <script src="{{ URL::asset('js/pages/auth/santriRegister.js') }}">
  </script>
  @endsection

  </html>