<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-users"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Pengguna</h4>
        </div>
        <div class="card-body">
          {{ $hitungUser }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-user-check"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Telah Daftar Ulang</h4>
        </div>
        <div class="card-body">
          {{ $hitungDaftarAkun }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-info">
        <i class="fas fa-address-card"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Data Telah Lengkap</h4>
        </div>
        <div class="card-body">
          {{ $hitungSemuaSantri }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-calendar-day"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Acara Pada Bulan Ini</h4>
        </div>
        <div class="card-body">
          {{ $hitungAcaraBulanIni }}
        </div>
      </div>
    </div>
  </div>
</div>