<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kelas_id')->nullable();
            $table->integer('tahun_ajaran_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('nis')->nullable();
            $table->string('nama')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('telepon')->nullable();
            $table->string('telepon_orangtua')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->integer('status')->default(1)->nullable();
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
        Schema::dropIfExists('siswas');
    }
}
