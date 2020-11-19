<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
  protected $table = 'santri';
  protected $fillable = [
    'nama',
    'prog_pendidikan_id',
    'jenis_kelamin',
    'kota_lahir_id',
    'tanggal_lahir',
    'kontak_utama',
    'nisn',
    'nis',
    'nik',
    'status',

    'kec_domisili_id',
    'alamat_domisili',

    'tahun_masuk',
    'tahun_lulus',

    'kelas_id',
    'ayah_id',
    'ibu_id',
    'wali_id',
    'pend_terakhir_id',
    'berkas_id',
    'user_id'
  ];

  public function setTanggalLahirAttribute($value)
  {
    $this->attributes['tanggal_lahir'] = date('Y-m-d', strtotime($value));
  }

  public function getTanggalLahirAttribute()
  {
    return date('d/m/Y', strtotime($this->attributes['tanggal_lahir']));
  }

  public function setKontakUtamaAttribute($value)
  {
    $no_kontak = str_replace("-", "", $value);

    $this->attributes['kontak_utama'] = $no_kontak;
  }

  public function getStatusAttribute()
  {
    switch ($this->attributes['status']) {
      case 1:
        return "Aktif";
        break;
      case 2:
        return "Sudah Lulus";
        break;
      case 3:
        return "Keluar";
        break;
      case 4:
        return "Dikeluarkan";
        break;

      default:
        return "Tidak Diketahui";
        break;
    }
  }

  public function getJenisKelaminAttribute()
  {
    $jk = $this->attributes['jenis_kelamin'];
    switch ($jk) {
      case 1:
        return 'Laki-laki';
        break;
      case 2:
        return 'Perempuan';
        break;
      default:
        return '?';
    }
  }

  public function getProgPendidikanIdAttribute()
  {
    $prodi = $this->attributes['prog_pendidikan_id'];
    switch ($prodi) {
      case 1:
        return 'SD';
        break;
      case 2:
        return 'SMP';
        break;
      case 3:
        return 'SMA';
        break;
      case 4:
        return 'Pend. Tahfidz (B)';
        break;
      case 5:
        return 'Pend. Tahfidz (M)';
        break;
      case 6:
        return 'Mahad Aly';
        break;
      default:
        return '?';
    }
  }
}
