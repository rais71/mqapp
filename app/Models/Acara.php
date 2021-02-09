<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
  use HasFactory;
  protected $table = 'acara';
  protected $fillable = [
    'judul',
    'awal',
    'akhir',
    'warna',
    'ulang',
    'url'
  ];

  public function setAwalAttribute($value)
  {
    $this->attributes['awal'] = date('Y-m-d', strtotime($value));
  }
  public function setAkhirAttribute($value)
  {
    $this->attributes['akhir'] = empty($value) ? null : date('Y-m-d', strtotime($value));
  }
}
