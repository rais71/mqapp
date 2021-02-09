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
      <h2 class="section-title">Kalender Akademik</h2>
      <p class="section-lead">
        Kalender dengan informasi terbaru berdasarkan tanggal.
      </p>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="fc-overflow">
                On Development
              </div>
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
<script src="{{ URL::asset('js/pages/kaldik.js') }}"></script>
@endsection