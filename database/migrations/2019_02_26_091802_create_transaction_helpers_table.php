<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionHelpersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_helpers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('transaction_id')->unsigned()->nullable()->index();
            $table->foreign('transaction_id')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_helpers');
    }
}
