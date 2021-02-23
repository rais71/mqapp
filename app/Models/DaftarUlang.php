<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarUlang extends Model
{
  use HasFactory;
  protected $table = 'daftar_ulang';
  protected $fillable = [
    'nama',
    'prog_pendidikan_id',
    'jenis_kelamin',
    'tanggal_lahir',
    'nama_ibu',
    'tahun_ajaran',
    'status'
  ];

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

  public function getStatusAttribute()
  {
    $jk = $this->attributes['status'];
    switch ($jk) {
      case 1:
        return 'Belum';
        break;
      case 2:
        return 'Terdaftar';
        break;
      case 3:
        return 'Sudah';
        break;
      default:
        return '?';
    }
  }

  public function setTanggalLahirAttribute($value)
  {
    $split = explode("-", $value);
    $this->attributes['tanggal_lahir'] = $split[2] . "-" . $split[1] . "-" . $split[0];
  }
}
