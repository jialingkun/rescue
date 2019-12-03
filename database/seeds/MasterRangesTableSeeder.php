<?php

use Illuminate\Database\Seeder;

class MasterRangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_ranges')->insert([
            'start' => 0,
            'end' => 50
        ]);

        DB::table('master_ranges')->insert([
            'start' => 51,
            'end' => 100
        ]);

        DB::table('master_ranges')->insert([
            'start' => 101,
            'end' => 150
        ]);

        DB::table('master_ranges')->insert([
            'start' => 151,
            'end' => 200
        ]);

        DB::table('master_ranges')->insert([
            'start' => 201,
            'end' => 250
        ]);
    }
}
