<?php

use Illuminate\Database\Seeder;

class StatusTransaksisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_transaksis')->insert([
            'keterangan' => 'Membuat panic button',
        ]);
        DB::table('status_transaksis')->insert([
            'keterangan' => 'Membuat code blue',
        ]);
        DB::table('status_transaksis')->insert([
            'keterangan' => 'User Bersedia Membantu (Panic Button)',
        ]);
        DB::table('status_transaksis')->insert([
            'keterangan' => 'User Memverifikasi Kejadian',
        ]);
        DB::table('status_transaksis')->insert([
            'keterangan' => 'Ambulan Bersedia Membantu',
        ]);
        DB::table('status_transaksis')->insert([
            'keterangan' => 'Ambulan verifikasi Kejadian (Serta mengisi follow)',
        ]);
        DB::table('status_transaksis')->insert([
            'keterangan' => 'Ambulan Selesai',
        ]);
        DB::table('status_transaksis')->insert([
            'keterangan' => 'Transaksi palsu',
        ]);
    }
}
