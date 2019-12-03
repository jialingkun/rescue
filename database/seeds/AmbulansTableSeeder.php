<?php

use Illuminate\Database\Seeder;

class AmbulansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ambulans')->insert([
            'username' => 'ambulance001',
            'id_role' => 2,
            'kode' => '001',
            'no_pol_ambulan' => 'L 3111 AA',
            'nama_rs' => 'RS Puri',
            'alamat_rs' => 'Jl. A. Yani',
            'no_telp_rs' => '085234567890',
            'lat' => '-7.3090122',
            'lang' => '112.7603225',
        ]);
    }
}
