<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(StatusTransaksisTableSeeder::class);
        $this->call(MasterRangesTableSeeder::class);
        $this->call(HospitalsTableSeeder::class);
        $this->call(AmbulansTableSeeder::class);
        $this->call(AedsTableSeeder::class);
    }
}
