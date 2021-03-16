@extends('master')

@section('title', 'Beranda')

@section('css-lib')
<link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
{{-- <link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
--}}
<link rel="stylesheet" href="{{ URL::asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
{{-- <link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
--}}
{{-- <link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
--}}
<link rel="stylesheet" href="{{ URL::asset('node_modules/chocolat/dist/css/chocolat.css') }}">
@endsection

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Santri</h1>
    </div>

    @include('flash_message')

    <div class="section-body">
      <h2 class="section-title">Data Diri Anda</h2>
      <p class="section-lead">Informasi tentang data diri anda.</p>
      <div class="card author-box card-primary">
        <div class="card-body">
          <div class="author-box-left">
            <img alt="image" src="{{ URL::asset('uploads/berkas/' . $santri->berkasFoto) }}"
              class="rounded-circle author-box-picture">
            <div class="clearfix"></div>
            <a href="#" class="badge mt-2 {{ $santri->statusBadge }}">{{ $santri->status }}</a>
            {{-- <a href="#" class="btn btn-primary mt-3 follow-btn" data-follow-action="alert('follow clicked');"
              data-unfollow-action="alert('unfollow clicked');">Follow</a> --}}
          </div>
          <div class="author-box-details">

            <div class="author-box-name">
              <a href="#">{{ $santri->nama }}</a>
            </div>
            <div class="author-box-job">{{ $santri->prog_pendidikan_id }}</div>
            <div class="author-box-description text-left">
              <div class="section-title">Informasi Utama</div>
              <p>
                <span class="idf">Nama </span>: {{ $santri->nama }}<br>
                <span class="idf">Program </span>: {{ $santri->prog_pendidikan_id }}<br>
                <span class="idf">Jenis Kelamin </span>: {{ $santri->jenis_kelamin }}<br>
                <span class="idf">Kontak Utama</span>: {{ $santri->kontak_utama }}<br>
                <br>
                <span class="idf">NISN</span>: {{ $santri->nisn }}<br>
                <span class="idf">NIK</span>: {{ $santri->nik }}<br>
                <span class="idf">NIS</span>: {{ $santri->nis }}<br>
                <br>
                <span class="idf">Tempat Lahir </span>: {{ $santri->kabLahir . ", " . $santri->provLahir }}<br>
                <span class="idf">Tanggal Lahir </span>: {{ $santri->tanggal_lahir }}<br>
                <span class="idf">Domisili </span>:
                {{ $santri->kecDomisili . ", " . $santri->kabDomisili . ", " . $santri->provDomisili }}<br>
                <span class="idf">Alamat Domisili </span>: {{ $santri->alamat_domisili }}<br>
              </p>
              <div class="section-title">Pendidikan Terakhir</div>
              <p>
                <span class="idf">Nama Institusi </span>: {{ $santri->namaPendTerakhir }}<br>
                <span class="idf">Lokasi </span>:
                {{ $santri->kecPendTerakhir . ", " . $santri->kabPendTerakhir . ", " . $santri->provPendTerakhir }}<br>
                <span class="idf">Alamat Institusi </span>: {{ $santri->alamatPendTerakhir }}<br>
              </p>
              <div class="section-title">Orangtua & Wali</div>
              <p>
                @if ($santri->isWaliAyah)
                <span class="idf">Wali Santri</span>: Ayah<br>
                @elseif ($santri->isWaliIbu)
                <span class="idf">Wali Santri</span>: Ibu<br>
                @else
                <span class="idf">Wali Santri</span>: {{ $santri->wali }}<br>
                <span class="idf">Nama Wali </span>: {{ $santri->namaWali }}<br>
                <span class="idf">Kontak Wali </span>: {{ $santri->kontakWali }}<br>
                <span class="idf">Pekerjaan Wali </span>: {{ $santri->pekerjaanWali }}<br>
                @endif
                <br>
                <span class="idf">Nama Ayah </span>: {{ $santri->namaAyah }}<br>
                <span class="idf">Kontak Ayah </span>: {{ $santri->kontakAyah }}<br>
                <span class="idf">Pekerjaan Ayah </span>: {{ $santri->pekerjaanAyah }}<br>
                <br>
                <span class="idf">Nama Ibu </span>: {{ $santri->namaIbu }}<br>
                <span class="idf">Kontak Ibu </span>: {{ $santri->kontakIbu }}<br>
                <span class="idf">Pekerjaan Ibu </span>: {{ $santri->pekerjaanIbu }}<br>
              </p>
              <div class="section-title">Berkas</div>
              <div class="gallery gallery-md" data-item-height="100">
                <div class="gallery-item" data-image="{{ URL::asset('uploads/berkas/' . $santri->berkasIjazahDepan) }}"
                  data-title="Ijazah Depan"></div>
                <div class="gallery-item"
                  data-image="{{ URL::asset('uploads/berkas/' . $santri->berkasIjazahBelakang) }}"
                  data-title="Ijazah Belakang"></div>
                <div class="gallery-item" data-image="{{ URL::asset('uploads/berkas/' . $santri->berkasAkte) }}"
                  data-title="Akte Kelahiran"></div>
                <div class="gallery-item" data-image="{{ URL::asset('uploads/berkas/' . $santri->berkasKK) }}"
                  data-title="Kartu Keluarga"></div>
                <div class="gallery-item" data-image="{{ URL::asset('uploads/berkas/' . $santri->berkasSKB) }}"
                  data-title="Surat Kelakuan Baik"></div>
                <div class="gallery-item" data-image="{{ URL::asset('uploads/berkas/' . $santri->berkasSKS) }}"
                  data-title="Surat Keterangan Sehat"></div>
              </div>
            </div>
          </div>
          <div class="w-100 d-sm-none"></div>
          {{-- <div class="float-right mt-sm-0 mt-3">
            <a href="#" class="btn">View Posts <i class="fas fa-chevron-right"></i></a>
          </div> --}}
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
{{-- <script src="{{ URL::asset('node_modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script> --}}
<script src="{{ URL::asset('node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
{{-- <script src="{{ URL::asset('node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
--}}
{{-- <script src="{{ URL::asset('node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script> --}}
{{-- <script src="{{ URL::asset('node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script> --}}
<script src="{{ URL::asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('node_modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
@endsection

@section('js-specific')
@endsection