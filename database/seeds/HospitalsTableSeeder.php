<?php

use Illuminate\Database\Seeder;

class HospitalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hospitals')->insert([
            'nama' => 'RS. Ayah Bunda',
            'alamat' => 'Jl. Mawar No 20',
            'telp' => '085234567890',
            'desc' => '-',
            'lat' => '-7.2990122',
            'lang' => '112.7703225',
        ]);

        DB::table('hospitals')->insert([
            'nama' => 'RS. Melati',
            'alamat' => 'Jl. Sudimoro No 1',
            'telp' => '085234567899',
            'desc' => '-',
            'lat' => '-7.3390130',
            'lang' => '112.7203275',
        ]);
    }
}
