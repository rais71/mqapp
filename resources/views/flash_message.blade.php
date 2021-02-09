@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible show fade mt-3 p-3">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
    {{ $message }}
  </div>
</div>
@endif

@if ($message = Session::get('danger'))
<div class="alert alert-danger alert-dismissible show fade mt-3 p-3">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
    {{ $message }}
  </div>
</div>
@endif

@if ($message = Session::get('danger-register'))
<div class="alert alert-danger">
  <div class="alert-body">
    <div class="alert-title">Ups Afwan, Kami tidak dapat menemukan data anda.</div>
    Harap pastikan <b>Nama Lengkap</b>, <b>Tanggal Lahir</b>, dan <b>Nama Ibu</b> sudah benar.
    Jika yakin sudah benar namun pesan ini tetap muncul silahkan hubungi kami.
    <br>
    <a href="https://api.whatsapp.com/send?phone=6281398008600&text=Assalamulaikum..."
      class="badge badge-success mt-2">WhatsApp kami</a>
  </div>
</div>
@endif

@if ($message = Session::get('success-register'))
<div class="alert alert-success alert-dismissible show fade mt-3 p-3">
  <button class="close" data-dismiss="alert">
    <span>&times;</span>
  </button>
  <div class="alert-body">
    <div class="alert-title">Alhamdulillah, pendaftaran berhasil.</div>
    Silahkan login dengan email dan password yang baru saja anda buat.
  </div>
</div>
@endif

@if ($errors->any() && Route::is('du'))
<div class="alert alert-danger alert-dismissible show fade mt-3 p-3">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
    @foreach ($errors->all() as $error)
    <li>{{ str_replace('There was an error on row', 'Terdapat error pada baris', $error) }}</li>
    @endforeach
  </div>
</div>
@endif