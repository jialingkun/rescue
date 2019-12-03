<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id_pengaduan')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->string('pesan');
            $table->timestamps();
        });

        Schema::table('pengaduans', function($table){
            $table->foreign('id_user')
            ->references('id_user')
            ->on('users')
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
        Schema::dropIfExists('pengaduans');
    }
}
