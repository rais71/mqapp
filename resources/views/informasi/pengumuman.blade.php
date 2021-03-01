@extends('master')

@section('title', 'Beranda')

@section('css-lib')
<link rel="stylesheet" href="{{ URL::asset('node_modules/fullcalendar/main.min.css') }}">
@endsection

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Pengumuman</h1>
    </div>

    <div class="section-body">
      <h2 class="section-title">Informasi Pengumuman</h2>
      <p class="section-lead">
        Informasi pengumuman terbaru untuk anda.
      </p>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              @canany(["pengumuman tambah", "pengumuman hapus"])
              <p>
                @can('pengumuman tambah')
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tambah-pengumuman"
                  aria-expanded="true" aria-controls="tambah-pengumuman">
                  <i class="fas fa-plus-circle"></i> Tambah Pengumuman
                </button>
                @endcan
              </p>
              @endcan

              @include('flash_message')

              @can('pengumuman tambah')
              {{-----------------------TAMBAH PENGUMUMAN -------------------------}}
              <div class="collapse rounded bg-secondary" id="tambah-pengumuman">
                <form action="{{ Route('pengumuman.simpan') }}" id="form-tambah" method="post">
                  @csrf
                  <div class="form-row p-4">
                    <div class="form-group col-md-12 mb-1">
                      {{----------------------- Nama Pengumuman ------------------------------}}
                      <label>Judul Pengumuman <b class="harus">*</b></label>
                      <input type="text"
                        class="form-control @if($errors->has('judul-pengumuman')){{ "is-invalid" }}@endif"
                        name="judul-pengumuman" id="judul-pengumuman" maxlength="50"
                        value="{{ old('judul-pengumuman') }}">
                      <span class="text-danger d-inline">
                        <small><i>{{ $errors->first('judul-pengumuman') }}</i></small>
                      </span>
                    </div>

                    {{----------------------- Deskripsi ------------------------------}}
                    <div class="form-group col-md-12 mb-1">
                      <label>Deskripsi <b class="harus">*</b></label><small> (Max. 500 huruf)</small>
                      <textarea class="form-control @if($errors->has('deskripsi')){{ "is-invalid" }}@endif" rows="3"
                        style="height: auto;" name="deskripsi" id="deskripsi"
                        maxlength="500">{{ old('deskripsi') }}</textarea>
                      <span class="text-danger d-inline"><small><i>{{ $errors->first('deskripsi') }}</i></small></span>
                    </div>

                    <div class="form-group px-1 m-0">
                      <small>Pengumuman bersifat 1 arah. Mohon cek judul dan isi pengumuman baik-baik sebelum
                        diumumkan.</small>
                    </div>
                    <div class="form-group col-md-12 mt-3">
                      <input class="btn btn-primary btn-md" type="submit" value="Umumkan">
                      <input class="btn btn-danger btn-md" type="button" id="batal-tambah" value="Batal"
                        data-toggle="collapse" data-target="#tambah-pengumuman" aria-expanded="true"
                        aria-controls="tambah-pengumuman">
                    </div>
                </form>
              </div>
            </div>
            @endcan

            <div class="mt-4 mb-2">
              <h5 class="d-inline">Belum Dibaca</h5>
              @if (auth()->user()->unreadNotifications()->count() != NULL)
              <form class="d-inline" action="{{ Route('pengumuman.dibaca_semua') }}" id="form-tambah" method="post">
                @csrf
                <button class="btn btn-primary btn-md d-inline px-1 py-0" type="submit"><i
                    class="fas fa-check-double"></i> Dibaca Semua</button>
              </form>
              @endif
            </div>
            @if (auth()->user()->unreadNotifications()->count() != NULL)
            @foreach(auth()->user()->unreadNotifications as $notification)
            <div class="alert alert-primary alert-has-icon">
              <div class="alert-icon"><i class="fas fa-bullhorn"></i></div>
              <div class="alert-body">
                <div class="alert-title">{{ $notification->data['judul'] }}
                  <span class="badge badge-light text-primary p-1">
                    {{ date('d M Y', strtotime($notification->created_at)) }}
                  </span>
                </div>
                {{ $notification->data['deskripsi'] }}
                <button class="btn .btn-outline-success btn-md px-1 py-0 text-info" type="submit"><i
                    class="fas fa-check"></i>
                  Telah Dibaca</button>
              </div>
            </div>
            @endforeach
            @else
            Tidak ada notifikasi yang belum dibaca.
            @endif
            <div class="mt-4 mb-2">
              <h5>Telah Dibaca</h5>
            </div>
            <div id="accordion">
              @foreach(auth()->user()->notifications as $notification)
              @if ($notification->read_at != NULL)
              <div class="accordion">
                <div class="accordion-header" role="button" data-toggle="collapse"
                  data-target="#pengumuman-sudah-dibaca" aria-expanded="true">
                  <h4 class="d-inline">{{ $notification->data['judul'] }}</h4>
                  <span class="badge badge-light text-primary p-1 d-inline">
                    {{ date('d M Y', strtotime($notification->created_at)) }}
                  </span>
                </div>
                <div class="accordion-body collapse show" id="pengumuman-sudah-dibaca" data-parent="#accordion">
                  <p class="mb-0">{{ $notification->data['deskripsi'] }}</p>
                </div>
              </div>
              @else
              Tidak ada notifikasi yang sudah dibaca.
              @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('js-lib')
<script src="{{ URL::asset('node_modules/fullcalendar/main.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js') }}">
</script>
@endsection

@section('js-specific')
<script src="{{ URL::asset('js/pages/pengumuman.js') }}"></script>
@endsection