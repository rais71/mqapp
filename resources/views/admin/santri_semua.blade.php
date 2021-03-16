@extends('master')

@section('title', 'Semua Santri')

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Santri</h1>
    </div>

    <div class="section-body">
      <h2 class="section-title">Seluruh Santri</h2>
      <p class="section-lead">Daftar seluruh santri yang terdaftar di Pesantren Madinatul Qur'an.</p>
      <a class="btn btn-primary" href="santri/tambah" role="button">Tambah Data</a>
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
                <th>Tahun Masuk</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($santri2 as $santri)
              <tr class="h-25">
                <th>
                  <div class="custom-checkbox custom-control">
                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                      id="checkbox-{{ $loop->iteration }}">
                    <label for="checkbox-{{ $loop->iteration }}" class="custom-control-label">&nbsp;</label>
                  </div>
                </th>
                <td>{{ $santri->nama }}</td>
                <td>{{ $santri->jenis_kelamin }}</td>
                <td>{{ $santri->prog_pendidikan_id }}</td>
                <td>{{ $santri->tahun_masuk }}</td>
                <td>
                  <div class="btn-group mb-1" role="group" aria-label="Basic example">
                    <a href="#" type='button' class="btn btn-primary"><i class="far fa-edit putih"></i></a>
                    <a href="{{ URL::to('admin/santri/' . $santri->id) }}" type='button' class="btn btn-info"><i
                        class="fas fa-info-circle putih"></i></a>
                    @can('santri hapus')
                    <button class="btn btn-danger tombol-konfirmasi-hapus" data-toggle="modal"
                      data-target="#konfirmasi-hapus" value="{{ $santri->id }}"><i
                        class="fas fa-trash putih"></i></button>
                    @endcan
                  </div>
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

{{---------------------------- MODAL BOOTSTRAP | KONFIRMASI HAPUS DATA --------------------------------------------}}
<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi-hapus">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judul-acara-modal">Konfirmasi Hapus?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus data santri ini beserta berkas-berkasnya?</p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        @can('santri hapus')
        <form id="form-konfirmasi-hapus" action="" method="post">
          @method('DELETE')
          @csrf
          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
            Saya yakin, Hapus!</button>
        </form>
        @endcan
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js-specific')
<script src="{{ URL::asset('js/pages/admin/santriSemua.js') }}"></script>
@endsection