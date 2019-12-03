<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id_role' => 3,
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'no_hp' => '085212341234',
            'alamat' => 'malang',
            'no_darurat' => '085212341233',
            'pesan' => '',
            'kode' => Hash::make('password'),
            'token' => str_random(64),
            'status' => 1,
            'remember_token' => '',
            'latitude' => '',
            'longitude' => '',
            'FCMToken' => '',
        ]);

    }
}
