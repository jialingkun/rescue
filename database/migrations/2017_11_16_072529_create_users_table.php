<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Role;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id_user')->unsigned();
            $table->integer('id_role')->unsigned()->default(1);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->string('alamat')->nullable();
            $table->string('no_darurat')->nullable();
            $table->string('pesan')->nullable();
            $table->string('kode', 256);
            $table->string('token')->nullable();
            $table->integer('status')->default(1);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function($table){
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
        Schema::dropIfExists('users');
    }
}
