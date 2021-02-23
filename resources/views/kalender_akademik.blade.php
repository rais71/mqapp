@extends('master')

@section('title', 'Beranda')

@section('css-lib')
<link rel="stylesheet" href="{{ URL::asset('node_modules/fullcalendar/main.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet"
  href="{{ URL::asset('node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
@endsection

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>KalDik</h1>
    </div>

    <div class="section-body">
      <h2 class="section-title">Kalender Akademik</h2>
      <p class="section-lead">
        Kalender dengan informasi terbaru berdasarkan tanggal.
      </p>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              @canany(["kalender tambah", "kalender hapus"])
              <p>
                @can('kalender tambah')
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tambahAcara"
                  aria-expanded="true" aria-controls="tambahAcara">
                  <i class="fas fa-plus-circle"></i> Tambah Acara
                </button>
                @endcan
              </p>
              @endcan

              @include('flash_message')

              {{-- <pre id="whereToPrint"></pre> --}}
              @can('kalender tambah')
              {{-----------------------TAMBAH ACARA -------------------------}}
              <div class="collapse rounded bg-secondary" id="tambahAcara">
                <form action="{{ Route('kaldik.simpan') }}" id="form-tambah" method="post">
                  @csrf
                  <div class="form-row p-4">
                    <div class="form-group col-md-4 mb-1">
                      {{----------------------- Nama Acara ------------------------------}}
                      <label>Nama Acara <b class="harus">*</b></label>
                      <input type="text" class="form-control @if($errors->has('nama-acara')){{ "is-invalid" }}@endif"
                        name="nama-acara" id="nama-acara" maxlength="50" value="{{ old('nama-acara') }}">
                      <span class="text-danger d-inline">
                        <small><i>{{ $errors->first('nama-acara') }}</i></small>
                      </span>
                    </div>

                    {{----------------------- Tanggal Mulai ------------------------------}}
                    <div class="form-group col-md-4 mb-1">
                      <label>Tanggal Mulai <b class="harus">*</b></label>
                      <input class="form-control datepicker @if ($errors->has('tgl-mulai')){{ "is-invalid" }}@endif"
                        type="text" id="tgl-mulai" name="tgl-mulai" value="{{ old('tgl-mulai') }}" autocomplete="off">
                      <span class="text-danger"><small><i>{{ $errors->first('tgl-mulai') }}</i></small></span>
                    </div>

                    {{----------------------- Tanggal Akhir ------------------------------}}
                    <div class="form-group col-md-4 mb-1">
                      <label>Tanggal Selesai</label>
                      <input class="form-control datepicker @if ($errors->has('tgl-selesai')){{ "is-invalid" }}@endif"
                        type="text" id="tgl-selesai" name="tgl-selesai" value="{{ old('tgl-selesai') }}"
                        autocomplete="off">
                      <span class="text-danger"><small><i>{{ $errors->first('tgl-selesai') }}</i></small></span>
                    </div>

                    {{----------------------- Deskripsi ------------------------------}}
                    <div class="form-group col-md-12 mb-1">
                      <label>Deskripsi</label><small> (Max. 500 huruf)</small>
                      <textarea class="form-control @if($errors->has('deskripsi')){{ "is-invalid" }}@endif" rows="3"
                        style="height: auto;" name="deskripsi" id="deskripsi"
                        maxlength="500">{{ old('deskripsi') }}</textarea>
                      <span class="text-danger d-inline"><small><i>{{ $errors->first('deskripsi') }}</i></small></span>
                    </div>

                    {{----------------------- Link Url ------------------------------}}
                    {{-- <div class="form-group col-md-4 mb-1">
                      <label>Alamat Link</label>
                      <input class="form-control @if ($errors->has('url')){{ "is-invalid" }}@endif" type="text"
                    id="url"
                    name="url" value="{{ old('url') }}" autocomplete="off">
                    <span class="text-danger"><small><i>{{ $errors->first('url') }}</i></small></span>
                  </div> --}}

                  {{----------------------- Warna Background ------------------------------}}
                  <div class="form-group col-md-4 mb-1">
                    <label>Warna Background <b class="harus">*</b></label>
                    <input type="text" class="form-control colorpickerinput" id="warna-bg" name="warna-bg"
                      value="{{ old('warna-bg') }}" autocomplete="off">
                    <span class="text-danger"><small><i>{{ $errors->first('warna-bg') }}</i></small></span>
                  </div>

                  {{----------------------- Opsi ------------------------------}}
                  <div class="form-group col-md-4 mb-1">
                    <label class="custom-switch mt-4">
                      <input type="checkbox" name="warna-dasar" id="warna-dasar" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">Warna Dasar</span>
                    </label>
                    <label class="custom-switch mb-1">
                      <input type="checkbox" name="ulangi-hari" id="ulangi-hari" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">Ulang Tiap Minggu</span>
                    </label>
                  </div>

                  <div class="form-group col-md-12 mt-3">
                    <input class="btn btn-primary btn-md" type="submit" value="Simpan Acara">
                    <input class="btn btn-danger btn-md" type="button" id="batal-tambah" value="Batal"
                      data-toggle="collapse" data-target="#tambahAcara" aria-expanded="true"
                      aria-controls="tambahAcara">
                  </div>
                </form>
              </div>
            </div>
            @endcan

          </div>
          <div class="card-body">
            <div id="acara" style="width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>

{{---------------------------- MODAL BOOTSTRAP | IMPORTS --------------------------------------------}}
<div class="modal fade" tabindex="-1" role="dialog" id="info-acara-modal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judul-acara-modal">Informasi Acara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Waktu : <b id="waktuAcara"></b></p>
        <p id="deskripsi-acara-modal"></p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        @can('kalender edit')
        {{-- <button type="button" class="btn btn-info"><i class="fas fa-pen-square"></i> Edit</button> --}}
        @endcan
        @can('kalender hapus')
        <form id="form-hapus-acara-modal" action="" method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger"><i class="fas fa-minus-square"></i>
            Hapus</button>
        </form>
        @endcan
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-lib')
<script src="{{ URL::asset('node_modules/fullcalendar/main.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js') }}">
</script>
<script src="{{ URL::asset('node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
@endsection

@section('js-specific')
<script src="{{ URL::asset('js/pages/kaldik.js') }}"></script>
@endsection