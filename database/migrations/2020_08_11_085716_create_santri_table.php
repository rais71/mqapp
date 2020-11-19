<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantriTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('santri', function (Blueprint $table) {
      $table->id();
      $table->string('nama', 50);
      $table->tinyInteger('prog_pendidikan_id');
      $table->tinyInteger('jenis_kelamin');
      $table->integer('kota_lahir_id');
      $table->date('tanggal_lahir');
      $table->string('kontak_utama');
      $table->char('nisn', 10)->unique();
      $table->char('nis', 9)->unique();
      $table->char('nik', 16)->unique();
      $table->tinyInteger('status');

      $table->integer('kec_domisili_id');
      $table->text('alamat_domisili');

      $table->year('tahun_masuk');
      $table->year('tahun_lulus');

      $table->integer('kelas_id')->nullable();
      $table->integer('ayah_id');
      $table->integer('ibu_id');
      $table->integer('wali_id');
      $table->integer('pend_terakhir_id');
      $table->integer('user_id')->nullable();
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
    Schema::dropIfExists('santri');
  }
}
