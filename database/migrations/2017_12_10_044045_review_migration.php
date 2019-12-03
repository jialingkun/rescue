<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id_review')->unsigned();
            $table->integer('id_transaksi')->unsigned();
            $table->integer('id_pengguna')->unsigned()->nullable();
            $table->string('review_pengguna')->nullable();
            $table->string('rating_pengguna')->nullable();
            $table->integer('id_ambulan')->unsigned()->nullable();
            $table->string('review_ambulan')->nullable();
            $table->string('rating_ambulan')->nullable();
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
        Schema::dropIfExists('roles');
    }
}
