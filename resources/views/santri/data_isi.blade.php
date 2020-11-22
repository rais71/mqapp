@extends('master')

@section('meta')
<meta name="var" content='{{ 
/* 0 */ old("kabupaten-lahir").','.
/* 1 */ old("kabupaten-domisili").','.
/* 2 */ old("kecamatan-domisili").','.
/* 3 */ old("kabupaten-sekolah").','.
/* 4 */ old("kecamatan-sekolah").','.
/* 5 */ old("tahun-lulus").','.
/* 6 */ old("tahun-masuk")
}}' />
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
      <h2 class="section-title">Lengkapi Data Diri</h2>
      <p class="section-lead">Silahkan lengkapi data anda untuk penyelesaikan daftar ulang.</p>
      <form action="/santri/data_isi" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card mt-3">
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

            {{----------------------- Program ------------------------------}}
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

            {{----------------------- Tempat Lahir | Provinsi ------------------------------}}
            <div class="form-group">
              <label>Tempat Lahir <b class="harus">*</b></label>
              <div class="form-row">
                <div class="form-group col-md-6 mb-1
                @if ($errors->has('provinsi-lahir')){{ "is-invalid" }}@endif">
                  <select id="provinsi-lahir" class="form-control select2" name="provinsi-lahir" id="provinsi-lahir">
                    <option value="0" disabled selected>Pilih Provinsi ...</option>
                    @foreach ($provinsi2 as $provinsi)
                    <option value="{{ $provinsi->id }}"
                      {{ (old('provinsi-lahir') == $provinsi->id) ? 'selected' : '' }}>
                      {{ $provinsi->nama }}
                    </option>
                    @endforeach
                  </select>
                  <span class="text-danger"><small><i>{{ $errors->first('provinsi-lahir') }}</i></small></span>
                </div>

                {{----------------------- Tempat Lahir | Kabupaten ------------------------------}}
                <div class="form-group col-md-6 mb-0
                @if ($errors->has('kabupaten-lahir')){{ "is-invalid" }}@endif">
                  <select id="kabupaten-lahir" class="form-control select2" name="kabupaten-lahir" id="kabupaten-lahir">
                    <option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>
                    <option value="0" disabled>Pilih Provinsi terlebih dahulu.</option>
                  </select>
                  <span class="text-danger"><small><i>{{ $errors->first('kabupaten-lahir') }}</i></small></span>
                </div>
                <div class="form-group col-md-6 mb-0">
                  <small id="passwordHelpBlock" class="form-text text-muted">
                    Jika tidak ada atau diluar Indonesia silahkan hubungi CS kami.
                  </small>
                </div>
              </div>
            </div>

            {{----------------------- Tanggal Lahir ------------------------------}}
            <div class="form-group">
              <label>Tanggal Lahir <b class="harus">*</b></label>
              <input class="form-control datepicker @if ($errors->has('tgl-lahir-santri')){{ "is-invalid" }}@endif"
                type="text" id="tgl-lahir-santri" name="tgl-lahir-santri" value="{{ old('tgl-lahir-santri') }}"
                autocomplete="off">
              <span class="text-danger"><small><i>{{ $errors->first('tgl-lahir-santri') }}</i></small></span>
            </div>

            {{----------------------- Kontak Utama ------------------------------}}
            <div class="form-group">
              <label>Nomor Kontak Utama <b class="harus">*</b></label>
              <input value="{{ old('no-kontak-utama') }}" type="text" class="form-control phone-number
              @if ($errors->has('no-kontak-utama')){{ "is-invalid" }}@endif" name="no-kontak-utama"
                id="no-kontak-utama">
              <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                Diutamakan memiliki <i>WhatsApp</i>.
              </small>
              <span class="text-danger d-inline"><small><i>{{ $errors->first('no-kontak-utama') }}</i></small></span>
            </div>

            {{----------------------- NISN ------------------------------}}
            <div class="form-group">
              <label>NISN <small>(Nomor Induk Siswa Nasional)</small> <b class="harus">*</b></label>
              <input type="text" class="form-control @if($errors->has('nisn')){{ "is-invalid" }}@endif" maxlength="10"
                name="nisn" id="nisn" value="{{ old('nisn') }}">
              <span class="text-danger d-inline"><small><i>{{ $errors->first('nisn') }}</i></small></span>
            </div>

            {{----------------------- NIK ------------------------------}}
            <div class="form-group">
              <label>NIK <small>(Nomor Induk Kependudukan)</small> <b class="harus">*</b></label>
              <input type="text" class="form-control @if($errors->has('nik-santri')){{ "is-invalid" }}@endif"
                maxlength="16" name="nik-santri" id="nik-santri" value="{{ old('nik-santri') }}">
              <span class="text-danger d-inline"><small><i>{{ $errors->first('nik-santri') }}</i></small></span>
            </div>

            {{----------------------- Domisili | Provinsi ------------------------------}}
            <div class="form-group">
              <label>Domisili <b class="harus">*</b></label>
              <div class="form-row">
                <div class="form-group col-md-4 mb-1 @if($errors->has('provinsi-domisili')){{ "is-invalid" }}@endif">
                  <select class="form-control select2" name="provinsi-domisili" id="provinsi-domisili">
                    <option value="0" disabled selected>Pilih Provinsi ...</option>
                    @foreach ($provinsi2 as $provinsi)
                    <option value="{{ $provinsi->id }}"
                      {{ (old('provinsi-domisili') == $provinsi->id) ? 'selected' : '' }}>
                      {{ $provinsi->nama }}
                    </option>
                    @endforeach
                  </select>
                  <span
                    class="text-danger d-inline"><small><i>{{ $errors->first('provinsi-domisili') }}</i></small></span>
                </div>

                {{----------------------- Domisili | Kabupaten ------------------------------}}
                <div class="form-group col-md-4 mb-1 @if($errors->has('kabupaten-domisili')){{ "is-invalid" }}@endif">
                  <select class="form-control select2" name="kabupaten-domisili" id="kabupaten-domisili">
                    <option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>
                    <option value="0" disabled>Pilih Provinsi terlebih dahulu.</option>
                  </select>
                  <span class="text-danger d-inline">
                    <small><i>{{ $errors->first('kabupaten-domisili') }}</i></small>
                  </span>
                </div>

                {{----------------------- Domisili | Kecamatan ------------------------------}}
                <div class="form-group col-md-4 mb-0 @if($errors->has('kecamatan-domisili')){{ "is-invalid" }}@endif">
                  <select class="form-control select2" name="kecamatan-domisili" id="kecamatan-domisili">
                    <option value="0" disabled selected>Pilih Kecamatan ...</option>
                    <option value="0" disabled>Pilih Kab. & Provinsi terlebih dahulu.</option>
                  </select>
                  <span class="text-danger d-inline">
                    <small><i>{{ $errors->first('kecamatan-domisili') }}</i></small>
                  </span>
                </div>
                <div class="form-group col-md-12 mb-0">
                  <small id="passwordHelpBlock" class="form-text text-muted">
                    Jika tidak ada atau diluar Indonesia silahkan hubungi CS kami.
                  </small>
                </div>
              </div>
            </div>

            {{----------------------- Domisili | Alamat Lengkap ------------------------------}}
            <div class="form-group">
              <label>Alamat Lengkap Domisili <b class="harus">*</b></label>
              <textarea class="form-control @if($errors->has('alamat-lengkap')){{ "is-invalid" }}@endif" rows="3"
                style="height: 100%;" name="alamat-lengkap" id="alamat-lengkap">{{ old('alamat-lengkap') }}</textarea>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('alamat-lengkap') }}</i></small>
              </span>
            </div>
          </div>
        </div>
        <div class="card mt-3">

          {{-------------------- Pendidikan Terakhir ------------------------------}}
          <div class="card-header">
            <h4>Pendidikan Terakhir</h4>
          </div>
          <div class="card-body">
            <div class="form-group">

              {{----------------------- Nama Sekolah ------------------------------}}
              <label>Nama Institusi Pendidikan <b class="harus">*</b></label>
              <input type="text" class="form-control @if($errors->has('pend-terakhir')){{ "is-invalid" }}@endif"
                name="pend-terakhir" id="pend-terakhir" value="{{ old('pend-terakhir') }}">
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('pend-terakhir') }}</i></small>
              </span>
            </div>

            {{----------------------- Lokasi Sekolah | Provinsi ------------------------------}}
            <div class="form-group">
              <label>Lokasi Institusi Pendidikan <b class="harus">*</b></label>
              <div class="form-row">
                <div class="form-group col-md-4 mb-1 @if($errors->has('provinsi-sekolah')){{ "is-invalid" }}@endif">
                  <select class="form-control select2" name="provinsi-sekolah" id="provinsi-sekolah">
                    <option value="0" disabled selected>Pilih Provinsi ...</option>
                    @foreach ($provinsi2 as $provinsi)
                    <option value="{{ $provinsi->id }}"
                      {{ (old('provinsi-sekolah') == $provinsi->id) ? 'selected' : '' }}>
                      {{ $provinsi->nama }}
                    </option>
                    @endforeach
                  </select>
                  <span class="text-danger d-inline">
                    <small><i>{{ $errors->first('provinsi-sekolah') }}</i></small>
                  </span>
                </div>

                {{----------------------- Lokasi Sekolah | Kabupaten ------------------------------}}
                <div class="form-group col-md-4 mb-1 @if($errors->has('kabupaten-sekolah')){{ "is-invalid" }}@endif">
                  <select class="form-control select2" name="kabupaten-sekolah" id="kabupaten-sekolah">
                    <option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>
                    <option value="0" disabled>Pilih Provinsi terlebih dahulu.</option>
                  </select>
                  <span class="text-danger d-inline">
                    <small><i>{{ $errors->first('kabupaten-sekolah') }}</i></small>
                  </span>
                </div>

                {{----------------------- Lokasi Sekolah | Kecamatan ------------------------------}}
                <div class="form-group col-md-4 mb-0 @if($errors->has('kecamatan-sekolah')){{ "is-invalid" }}@endif">
                  <select class="form-control select2" name="kecamatan-sekolah" id="kecamatan-sekolah">
                    <option value="0" disabled selected>Pilih Kecamatan ...</option>
                    <option value="0" disabled>Pilih Kab. & Provinsi terlebih dahulu.</option>
                  </select>
                  <span class="text-danger d-inline">
                    <small><i>{{ $errors->first('kecamatan-sekolah') }}</i></small>
                  </span>
                </div>
                <div class="form-group col-md-12 mb-0">
                  <small id="passwordHelpBlock" class="form-text text-muted">
                    Jika tidak ada atau diluar Indonesia silahkan hubungi CS kami.
                  </small>
                </div>
              </div>
            </div>

            {{----------------------- Lokasi Sekolah | Alamat Lengkap ------------------------------}}
            <div class="form-group">
              <label>Alamat Lengkap Instansi Pendidikan</label>
              <textarea class="form-control @if($errors->has('alamat-lengkap-sekolah')){{ "is-invalid" }}@endif"
                rows="3" style="height: 100%;" name="alamat-lengkap-sekolah"
                id="alamat-lengkap-sekolah">{{ old('alamat-lengkap-sekolah') }}</textarea>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('alamat-lengkap-sekolah') }}</i></small>
              </span>
            </div>

            {{----------------------- Tahun Lulus ------------------------------}}
            <div class="form-row">
              <div class="form-group col-md-6 mb-1 @if($errors->has('tahun-lulus')){{ "is-invalid" }}@endif">
                <label>Tahun Lulus <b class="harus">*</b></label>
                <select class="custom-select selectric" name="tahun-lulus" id="tahun-lulus">
                  <option value="0" selected disabled>Pilih Tahun Lulus ...</option>
                </select>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('tahun-lulus') }}</i></small>
                </span>
              </div>

              {{----------------------- Tahun Masuk ------------------------------}}
              <div class="form-group col-md-6 mb-1 @if($errors->has('tahun-masuk')){{ "is-invalid" }}@endif">
                <label>Tahun Masuk Madinatul Qur'an</label>
                <select class="custom-select selectric" name="tahun-masuk" id="tahun-masuk">
                  <option value="0" selected disabled>Pilih Tahun Masuk ...</option>
                </select>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('tahun-masuk') }}</i></small>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="card mt-3">

          {{-------------------- Orang Tua & Wali ------------------------------}}
          <div class="card-header">
            <h4>Orang Tua & Wali</h4>
          </div>
          <div class="card-body row">
            <div class="col-12 col-md-6 col-lg-6">

              {{----------------------- Nama Ayah Kandung ------------------------------}}
              <div class="form-group">
                <label>Nama Ayah Kandung <b class="harus">*</b></label>
                <input type="text" class="form-control @if($errors->has('nama-ayah')){{ "is-invalid" }}@endif"
                  name="nama-ayah" id="nama-ayah" value="{{ old('nama-ayah') }}">
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('nama-ayah') }}</i></small>
                </span>
              </div>


              {{----------------------- Kontak Ayah ------------------------------}}
              <div class="form-group">
                <label>Nomor Kontak Ayah <b class="harus">*</b></label>
                <input type="text"
                  class="form-control phone-number @if($errors->has('kontak-ayah')){{ "is-invalid" }}@endif"
                  name="kontak-ayah" id="kontak-ayah" value="{{ old('kontak-ayah') }}">
                <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                  Diutamakan memiliki <i>WhatsApp</i>.
                </small>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('kontak-ayah') }}</i></small>
                </span>
              </div>
            </div>

            {{----------------------- Nama Ibu Kandung ------------------------------}}
            <div class="col-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label>Nama Ibu Kandung <b class="harus">*</b></label>
                <input type="text" class="form-control @if($errors->has('nama-ibu')){{ "is-invalid" }}@endif"
                  name="nama-ibu" id="nama-ibu" value="{{ old('nama-ibu') }}">
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('nama-ibu') }}</i></small>
                </span>
              </div>

              {{----------------------- Kontak Ibu ------------------------------}}
              <div class="form-group">
                <label>Nomor Kontak Ibu <b class="harus">*</b></label>
                <input type="text"
                  class="form-control phone-number @if($errors->has('kontak-ibu')){{ "is-invalid" }}@endif"
                  name="kontak-ibu" id="kontak-ibu" value="{{ old('kontak-ibu') }}">
                <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                  Diutamakan memiliki <i>WhatsApp</i>.
                </small>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('kontak-ibu') }}</i></small>
                </span>
              </div>
            </div>

            {{----------------------- Siapa Wali? ------------------------------}}
            <div class="col-12 siapa-wali">
              <div class="form-group @if($errors->has('wali')){{ "is-invalid" }}@endif">
                <label>Wali <b class="harus">*</b></label>
                <select class="custom-select selectric" id="wali" name="wali">
                  <option value="" disabled selected>Pilih Wali ...</option>
                  <option value="1" {{ (old('wali') == 1) ? 'selected' : '' }}>Ayah</option>
                  <option value="2" {{ (old('wali') == 2) ? 'selected' : '' }}>Ibu</option>
                  <option value="3" {{ (old('wali') == 3) ? 'selected' : '' }}>Lainnya</option>
                </select>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('wali') }}</i></small>
                </span>
              </div>

              {{----------------------- Relasi Wali ------------------------------}}
              <div class="form-group data-wali hidden">
                <label>Relasi Wali <b class="harus">*</b></label>
                <input type="text" class="form-control @if($errors->has('relasi-wali')){{ "is-invalid" }}@endif"
                  name="relasi-wali" id="relasi-wali" value="{{ old('relasi-wali') }}">
                <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                  Hubungan wali dengan peserta didik. <i>Misal: Tetangga, Paman, dsb.</i>
                </small>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('relasi-wali') }}</i></small>
                </span>
              </div>
            </div>

            {{----------------------- Nama Wali ------------------------------}}
            <div class="col-12 col-md-6 col-lg-6 data-wali hidden">
              <div class="form-group">
                <label>Nama Wali <b class="harus">*</b></label>
                <input type="text" class="form-control @if($errors->has('nama-wali')){{ "is-invalid" }}@endif"
                  name="nama-wali" id="nama-wali" value="{{ old('nama-wali') }}">
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('nama-wali') }}</i></small>
                </span>
              </div>

              {{----------------------- Kontak Wali ------------------------------}}
              <div class="form-group">
                <label>Nomor Kontak Wali <b class="harus">*</b></label>
                <input type="text" class="form-control @if($errors->has('kontak-wali')){{ "is-invalid" }}@endif"
                  name="kontak-wali" id="kontak-wali" value="{{ old('kontak-wali') }}">
                <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                  Diutamakan memiliki <i>WhatsApp</i>.
                </small>
                <span class="text-danger d-inline">
                  <small><i>{{ $errors->first('kontak-wali') }}</i></small>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="card mt-3">

          {{-------------------- Upload Berkas ------------------------------}}
          <div class="card-header">
            <h4>Upload Berkas</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Foto <b class="harus">*</b></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input @if($errors->has('berkas-foto')){{ "is-invalid" }}@endif"
                  id="berkas-foto" name="berkas-foto" value="{{ old('berkas-foto') }}">
                <label class="custom-file-label" for="berkas-foto">Upload Foto ...</label>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted d-inline">
                Foto berwarna 4x6 dengan wajah terlihat jelas dan pakaian yang sopan. <i>(Format:
                  .jpg, .jpeg, atau .png & Maks. 2 Mb)</i>
              </small>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('berkas-foto') }}</i></small>
              </span>
            </div>
            <div class="form-group">
              <label>Ijazah Pendidikan Terakhir - Bag. Depan <b class="harus">*</b></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="berkas-ijazah-depan" name="berkas-ijazah-depan">
                <label class="custom-file-label" for="berkas-ijazah-depan">Upload Ijazah Depan ...</label>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted">
                Scan ijazah bagian DEPAN, pastikan tulisan terbaca jelas. <i>(Format: .jpg, .jpeg, atau .png & Maks. 2
                  Mb)</i>
              </small>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('berkas-ijazah-depan') }}</i></small>
              </span>
            </div>
            <div class="form-group">
              <label>Ijazah Pendidikan Terakhir - Bag. Belakang <b class="harus">*</b></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="berkas-ijazah-belakang" name="berkas-ijazah-belakang">
                <label class="custom-file-label" for="berkas-ijazah-belakang">Upload Ijazah Belakang ...</label>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted">
                Scan ijazah bagian BELAKANG, pastikan tulisan terbaca jelas. <i>(Format: .jpg, .jpeg, atau .png & Maks.
                  2 Mb)</i>
              </small>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('berkas-ijazah-belakang') }}</i></small>
              </span>
            </div>
            <div class="form-group">
              <label>Akte Kelahiran <b class="harus">*</b></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="berkas-akte" name="berkas-akte">
                <label class="custom-file-label" for="berkas-akte">Upload Akte Lahir ...</label>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted">
                Scan akte kelahiran asli, pastikan tulisan terbaca jelas. <i>(Format: .jpg, .jpeg, atau .png & Maks. 2
                  Mb)</i>
              </small>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('berkas-akte') }}</i></small>
              </span>
            </div>
            <div class="form-group">
              <label>Kartu Keluarga <b class="harus">*</b></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="berkas-kk" name="berkas-kk">
                <label class="custom-file-label" for="berkas-kk">Upload KK ...</label>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted">
                Scan kartu keluarga asli, pastikan tulisan terbaca jelas. <i>(Format: .jpg, .jpeg, atau .png & Maks. 2
                  Mb)</i>
              </small>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('berkas-kk') }}</i></small>
              </span>
            </div>
            <div class="form-group">
              <label>Surat Kelakuan Baik <b class="harus">*</b></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="berkas-skb" name="berkas-skb">
                <label class="custom-file-label" for="berkas-skb">Upload SKB ...</label>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted">
                Scan surat kelakuan baik asli dari sekolah, pastikan tulisan terbaca jelas. <i>(Format: .jpg, .jpeg,
                  atau .png & Maks. 2 Mb)</i>
              </small>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('berkas-skb') }}</i></small>
              </span>
            </div>
            <div class="form-group">
              <label>Surat Keterangan Sehat <b class="harus">*</b></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="berkas-ket-sehat" name="berkas-ket-sehat">
                <label class="custom-file-label" for="berkas-ket-sehat">Upload SKS ...</label>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted">
                Scan surat keterangan sehat asli dari dokter, pastikan tulisan terbaca jelas. <i>(Format: .jpg, .jpeg,
                  atau .png & Maks. 2 Mb)</i>
              </small>
              <span class="text-danger d-inline">
                <small><i>{{ $errors->first('berkas-ket-sehat') }}</i></small>
              </span>
            </div>
          </div>
        </div>
        <div class="card mt-3">
          <input class="btn btn-primary btn-lg" type="submit" value="Simpan Data">
        </div>
      </form>
    </div>
  </section>
</div>
@endsection

@section('js-lib')
<script src="{{ URL::asset('node_modules/cleave.js/dist/cleave.min.js') }}"></script>
{{-- <script src="{{ URL::asset('node_modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script> --}}
{{-- <script src="{{ URL::asset('node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script> --}}
{{-- <script src="{{ URL::asset('node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
--}}
{{-- <script src="{{ URL::asset('node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script> --}}
{{-- <script src="{{ URL::asset('node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script> --}}
<script src="{{ URL::asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js') }}">
</script>
@endsection

@section('js-specific')
<script src="{{ URL::asset('js/pages/santri/dataIsi.js') }}"></script>
@endsection