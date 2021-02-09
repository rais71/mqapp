<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcaraTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('acara', function (Blueprint $table) {
      $table->id();
      $table->string('judul');
      $table->date('awal');
      $table->date('akhir')->nullable();
      $table->string('warna');
      $table->tinyInteger('ulang');
      $table->string('url')->nullable();
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
    Schema::dropIfExists('acara');
  }
}
