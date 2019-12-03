<?php

use Illuminate\Database\Seeder;

class AedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('aeds')->insert([
            'nama' => 'AED Tools 1i',
            'alamat' => 'Jl. Sudimoro No 3',
            'desc' => '-',
            'lat' => '-7.3290130',
            'lang' => '112.7103275',
        ]);

        DB::table('aeds')->insert([
            'nama' => 'AED Tools 1i',
            'alamat' => 'Jl. Sudimoro No 10',
            'desc' => '-',
            'lat' => '-7.3110130',
            'lang' => '112.7003275',
        ]);

        DB::table('aeds')->insert([
            'nama' => 'AED Tools 1i',
            'alamat' => 'Jl. Sudimoro No 33',
            'desc' => '-',
            'lat' => '-7.3690130',
            'lang' => '112.6103275',
        ]);

    }
}
