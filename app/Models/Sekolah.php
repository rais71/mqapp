<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
  protected $table = 'sekolah';
  protected $fillable = [
    'nama',
    'kec_sekolah_id',
    'alamat_sekolah',
  ];
}
