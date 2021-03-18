<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Esteban Dido',
            'username' => 'esteban',
            'password' => bcrypt('estebandido'),
            'created_at' => Carbon::now()
        ]);
        
        DB::table('users')->insert([
            'name' => 'Monica Martinez',
            'username' => 'moni',
            'password' => bcrypt('monica123'),
            'created_at' => Carbon::now()
        ]);
    }
}
