<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
  protected $table = 'lok_negara';

  public function getNameAttribute($value)
  {
    return ucwords(strtolower($value));
  }
}
