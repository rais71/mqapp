@extends('master')

@section('title', 'Beranda')

@section('css-lib')
<link rel="stylesheet" href="{{ URL::asset('node_modules/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/weathericons/css/weather-icons.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/weathericons/css/weather-icons-wind.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('node_modules/summernote/dist/summernote-bs4.css') }}">
@endsection

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Beranda</h1>
    </div>

    @can('beranda admin')
    @include('admin.beranda')
    @endcan

    @can('beranda santri')
    @include('santri.beranda')
    @endcan

    {{-- @role('wali santri')
    I am a writer!
    @else
    I am not a writer...
    @endrole --}}

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