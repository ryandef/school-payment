<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_kelas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('siswa_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->integer('tahun_ajaran_id')->nullable();
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
        Schema::dropIfExists('log_kelas');
    }
}
