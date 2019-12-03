<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmbulansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulans', function (Blueprint $table) {
            $table->increments('id_ambulan')->unsigned();
            $table->string('username');
            $table->integer('id_role')->unsigned()->default(2);
            $table->string('kode');
            $table->string('token')->nullable();
            $table->string('no_pol_ambulan');
            $table->string('nama_rs');
            $table->string('alamat_rs');
            $table->string('no_telp_rs');
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->string('FCMToken')->nullable();
            $table->timestamps();
        });

        Schema::table('ambulans', function($table){
            $table->foreign('id_role')
            ->references('id_role')
            ->on('roles')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambulans');
    }
}
