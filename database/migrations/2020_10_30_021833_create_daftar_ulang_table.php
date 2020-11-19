<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarUlangTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('daftar_ulang', function (Blueprint $table) {
      $table->id();
      $table->string('nama', 50);
      $table->tinyInteger('prog_pendidikan_id');
      $table->tinyInteger('jenis_kelamin');
      $table->date('tanggal_lahir');
      $table->string('nama_ibu', 50);
      $table->string('tahun_ajaran', 12);
      $table->tinyInteger('status');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('daftar_ulang');
  }
}
