<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ortuwali extends Model
{
  use HasFactory;
  protected $table = 'ortuwali';

  protected $fillable = [
    'nama',
    'kontak',
    'pekerjaan',
    'sebagai_wali'
  ];
}
