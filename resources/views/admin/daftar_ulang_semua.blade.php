@extends('admin.master')

@section('title', 'Daftar Ulang')

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Daftar Ulang</h1>
    </div>

    <div class="section-body">
      <h2 class="section-title">Data Daftar Ulang Santri</h2>
      <p class="section-lead">Data calon santri untuk dilengkapi datanya, jika sudah lengkap dapat di akses di menu
        Santri Aktif.</p>
      <a class="btn btn-primary" href="du/tambah" role="button">Tambah Daftar Ulang</a>
      @include('flash_message')
      <div class="card mt-3">
        <div class="table-responsive">
          <table class="table table-hover table-fit">
            <thead style="background: #f5f5f5">
              <tr>
                <th>
                  <div class="custom-checkbox custom-control">
                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                      class="custom-control-input" id="checkbox-all">
                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                  </div>
                </th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Program</th>
                <th>Tahun Ajaran</th>
                <th data-toggle="tooltip" title="Status santri sudah daftar ulang atau belum.">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($du2 as $du)
              <tr class="h-25">
                <th>
                  <div class="custom-checkbox custom-control">
                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                      id="checkbox-{{ $loop->iteration }}">
                    <label for="checkbox-{{ $loop->iteration }}" class="custom-control-label">&nbsp;</label>
                  </div>
                </th>
                <td>{{ $du->nama }}</td>
                <td>{{ $du->jenis_kelamin }}</td>
                <td>{{ $du->prog_pendidikan_id }}</td>
                <td>{{ $du->tahun_ajaran }}</td>
                <td>
                  @if ($du->status == "Belum")
                  <span class="badge badge-danger">{{ $du->status }}</span>
                  @else
                  <span class="badge badge-success">{{ $du->status }}</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr class="h-25">
                <td colspan="6">
                  <div class="card-body">
                    <div class="empty-state" data-height="400">
                      <div class="empty-state-icon">
                        <i class="fas fa-question"></i>
                      </div>
                      <h2>Afwan, Kami tidak dapat menemukan data</h2>
                      <p class="lead">
                        Untuk menghilangkan notifikasi ini silahkan tambahkan setidaknya 1 data.
                      </p>
                      <a href="santri/tambah" class="btn btn-primary mt-4">Tambah Data Baru</a>
                      <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="mt-4 bb">Refresh halaman</a>
                    </div>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="section-body">
      </div>
    </div>
  </section>
</div>
@endsection
@section('js-specific')
<script src="{{ URL::asset('js/pages/admin/daftarUlangSemua.js') }}"></script>
@endsection