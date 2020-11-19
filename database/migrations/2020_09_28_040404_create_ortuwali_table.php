<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrtuwaliTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ortuwali', function (Blueprint $table) {
      $table->id();
      $table->string('nama');
      $table->string('kontak');
      $table->string('relasi');
      $table->string('pekerjaan')->nullable();

      $table->boolean('sebagai_wali');
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
    Schema::dropIfExists('ortuwali');
  }
}
