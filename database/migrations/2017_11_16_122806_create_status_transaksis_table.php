<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->increments('id_transaksi')->unsigned();
            $table->integer('tipe_transaksi')->unsigned();
            $table->integer('id_status')->unsigned()->default(1);
            $table->integer('id_ambulan')->unsigned()->nullable();
            $table->integer('id_penolong')->unsigned()->nullable();
            $table->integer('id_korban')->unsigned()->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('followup')->nullable();
            $table->string('foto')->nullable();
            $table->dateTime('waktu_pertolongan_awam')->nullable();
            $table->integer('range_id')->unsigned()->nullable()->index();
            $table->foreign('range_id')->references('id')->on('master_ranges')->onDelete('cascade');
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
        Schema::dropIfExists('transaksis');
    }
}
