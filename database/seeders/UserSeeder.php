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
            'name' => 'Administrador',
            'username' => 'admin',
            'password' => bcrypt('secret'),
            'created_at' => Carbon::now()
        ]);
        
        DB::table('users')->insert([
            'name' => 'Cajero',
            'username' => 'cajero',
            'password' => bcrypt('cajero1'),
            'created_at' => Carbon::now()
        ]);
    }
}
