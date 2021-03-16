@extends('master')

@section('title', 'Daftar Ulang')

@section('main-content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Daftar Ulang</h1>
    </div>

    <div class="section-body">
      <form action="/admin/santri/du/hapus_terpilih" method="post">
        @csrf
        @method('delete')
        <h2 class="section-title">Data Daftar Ulang Santri</h2>
        <p class="section-lead">Data calon santri untuk dilengkapi datanya, jika sudah lengkap dapat di akses di menu
          Santri Aktif.</p>
        <a class="btn btn-primary" href="du/tambah" role="button"><i class="fas fa-plus-circle"></i> Tambah</a>
        <button class="btn btn-danger" role="button" type="submit" name="submit">
          <i class="fas fa-minus-circle"></i> Hapus
        </button>
        {{-- <a class="btn btn-danger" role="button" type="submit" name="submit" href="#">
          <i class="fas fa-minus-circle"></i> Hapus</a> --}}
        <div class="btn-group" role="group" aria-label="Import export">
          <button class="btn btn-info" data-toggle="modal" data-target="#importDaftarulang" type="button">
            <i class="fas fa-cloud-upload-alt"></i> Import
          </button>
          <a class="btn btn-info" href="/admin/santri/du/export" type="button">
            <i class="fas fa-cloud-download-alt"></i> Export
          </a>
        </div>

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
                <tr class="h-25" id="duid{{ $du->id }}">
                  <th>
                    <div class="custom-checkbox custom-control">
                      <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                        id="checkbox-{{ $du->id }}" name="cbdu[]" value="{{ $du->id }}">
                      <label for="checkbox-{{ $du->id }}" class="custom-control-label">&nbsp;</label>
                    </div>
                  </th>
                  <td>{{ $du->nama }}</td>
                  <td>{{ $du->jenis_kelamin }}</td>
                  <td>{{ $du->prog_pendidikan_id }}</td>
                  <td>{{ $du->tahun_ajaran }}</td>
                  <td>
                    @if ($du->status == "Belum")
                    <span class="badge badge-danger">
                      <i class="fas fa-times"></i> {{ $du->status }}
                    </span>
                    @elseif ($du->status == "Terdaftar")
                    <span class="badge badge-warning">
                      <i class="fas fa-clipboard-list"></i> {{ $du->status }}
                    </span>
                    @else
                    <span class="badge badge-success">
                      <i class="fas fa-check"></i> {{ $du->status }}
                    </span>
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
      </form>
    </div>
  </section>
</div>

{{---------------------------- MODAL BOOTSTRAP | IMPORTS --------------------------------------------}}
<div class="modal fade" tabindex="-1" role="dialog" id="importDaftarulang">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Import Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/admin/santri/du/import" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="import-daftarulang" name="import-daftarulang"
                accept=".xls,.xlsx" required>
              <label class="custom-file-label" for="import-daftarulang">Upload Excel ...</label>
            </div>
            <small id="passwordHelpBlock" class="form-text text-muted">
              Pastikan upload sesuai dengan format standar contoh.
              <a href="/admin/santri/du/import/file_contoh"><b>(Download Contoh)</b></a>.
            </small>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </form>
    </div>
  </div>
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
        <p>Apakah anda yakin ingin menghapus data daftar ulang santri berserta akunnya?</p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        @can('daftarulang hapus')
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
<script src="{{ URL::asset('js/pages/admin/daftarUlangSemua.js') }}"></script>
@endsection