<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('siswa_id')->nullable();
            $table->integer('approved_id')->nullable();
            $table->integer('subtotal')->nullable();
            $table->integer('kode_unik')->nullable();
            $table->integer('total')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->longText('bukti')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('uuid')->nullable();
            $table->datetime('batas_bayar')->nullable();
            $table->datetime('waktu_diterima')->nullable();
            $table->longText('invoice')->nullable();
            $table->integer('tunai')->default(0)->nullable();
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
        Schema::dropIfExists('pembayarans');
    }
}
