@extends('master')

@section('meta')
<meta name="var" content='{{ old("tahun-ajaran") }}' />
@endsection

@section('title', 'Beranda')

@section('css-lib')
<link rel="stylesheet" href="{{ URL::asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
@endsection

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Santri</h1>
    </div>

    <div class="section-body">
      <h2 class="section-title">Tambah Data Daftar Ulang</h2>
      <p class="section-lead">Tambah santri yang telah lulus tes PSB untuk daftar ulang.</p>
      <form action="/admin/santri/du/simpan" method="post" enctype="multipart/form-data">
        @csrf
        <div class=" card mt-3">
          {{-------------------- Data Diri ------------------------------}}
          <div class="card-header">
            <h4>Data diri</h4>
          </div>
          <div class="card-body">

            {{----------------------- Nama ------------------------------}}
            <div class="form-group">
              <label>Nama Lengkap <b class="harus">*</b></label>
              <input type="text" value="{{ old('nama-santri') }}" class="form-control 
              @if ($errors->has('nama-santri')){{ "is-invalid" }}@endif" name="nama-santri" id="nama-santri">
              <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                Mohon diisi sesuai dengan ijazah / KTP.
              </small>
              <span class="text-danger d-inline"><small><i>{{ $errors->first('nama-santri') }}</i></small></span>
            </div>

            {{----------------------- Program Pendidikan ------------------------------}}
            <div class="form-row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group @if($errors->has('program')){{ "is-invalid" }}@endif">
                  <label>Program Pendidikan <b class="harus">*</b></label>
                  <select class="custom-select selectric" name="program" id="program">
                    <option value="" disabled selected>Pilih Program ...</option>
                    <option value="1" {{ (old('program') == 1) ? 'selected' : '' }}>SD</option>
                    <option value="2" {{ (old('program') == 2) ? 'selected' : '' }}>SMP</option>
                    <option value="3" {{ (old('program') == 3) ? 'selected' : '' }}>SMA</option>
                    <option value="4" {{ (old('program') == 4) ? 'selected' : '' }}>Pend. Tahfidz (Beasiswa)</option>
                    <option value="5" {{ (old('program') == 5) ? 'selected' : '' }}>Pend. Tahfidz (Mandiri)</option>
                    <option value="6" {{ (old('program') == 6) ? 'selected' : '' }}>Mahad Aly</option>
                  </select>
                  <span class="text-danger"><small><i>{{ $errors->first('program') }}</i></small></span>
                </div>
              </div>

              {{----------------------- Tahun Ajaran Masuk ------------------------------}}
              <div class="form-group col-md-6 mb-1 @if($errors->has('tahun-ajaran')){{ "is-invalid" }}@endif">
                <label>Tahun Ajaran Masuk</label>
                <select class="custom-select selectric" name="tahun-ajaran" id="tahun-ajaran">
                  <option value="0" selected disabled>Pilih Tahun Masuk ...</option>
                </select>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('tahun-ajaran') }}</i></small>
                </span>
              </div>
            </div>

            {{----------------------- Jenis Kelamin ------------------------------}}
            <div class="form-group @if($errors->has('jenis-kelamin')){{ "is-invalid" }}@endif">
              <label>Jenis Kelamin <b class="harus">*</b></label>
              <select value="{{ old('jenis-kelamin') }}" class=" custom-select selectric" name="jenis-kelamin"
                id="jenis-kelamin">
                <option value="" disabled selected>Pilih Jenis Kelamin ...</option>
                <option value="1" {{ (old('jenis-kelamin') == 1) ? 'selected' : '' }}>
                  <i class="fa fa-male"></i> Laki-laki
                </option>
                <option value="2" {{ (old('jenis-kelamin') == 2) ? 'selected' : '' }}>
                  <i class="fa fa-female"></i> Perempuan
                </option>
              </select>
              <span class="text-danger"><small><i>{{ $errors->first('jenis-kelamin') }}</i></small></span>
            </div>

            <div class="form-row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                  <label>Nama Ibu Kandung <b class="harus">*</b></label>
                  <input type="text" class="form-control @if($errors->has('nama-ibu')){{ "is-invalid" }}@endif"
                    name="nama-ibu" id="nama-ibu" value="{{ old('nama-ibu') }}">
                  <span class="text-danger d-inline">
                    <small><i>{{ $errors->first('nama-ibu') }}</i></small>
                  </span>
                </div>
              </div>

              {{----------------------- Tanggal Lahir ------------------------------}}
              <div class="form-group col-md-6 mb-1">
                <label>Tanggal Lahir <b class="harus">*</b></label>
                <input class="form-control datepicker @if ($errors->has('tgl-lahir-santri')){{ "is-invalid" }}@endif"
                  type="text" id="tgl-lahir-santri" name="tgl-lahir-santri" value="{{ old('tgl-lahir-santri') }}"
                  autocomplete="off">
                <span class="text-danger"><small><i>{{ $errors->first('tgl-lahir-santri') }}</i></small></span>
              </div>
            </div>

            <div class="card mt-3">
              <input class="btn btn-primary btn-lg" type="submit" value="Tambah Daftar Ulang">
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>
@endsection

@section('js-lib')
<script src="{{ URL::asset('node_modules/cleave.js/dist/cleave.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js') }}">
</script>
@endsection

@section('js-specific')
<script src="{{ URL::asset('js/pages/admin/daftarUlangTambah.js') }}"></script>
@endsection