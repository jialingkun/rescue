<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'keterangan' => 'Penduduk',
        ]);

        DB::table('roles')->insert([
            'keterangan' => 'Ambulan',
        ]);

        DB::table('roles')->insert([
            'keterangan' => 'Admin',
        ]);
    }
}
