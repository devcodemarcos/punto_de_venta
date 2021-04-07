<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'type' => 'Unidad',
            'created_at' => Carbon::now()
        ]);
        
        DB::table('units')->insert([
            'type' => 'Kilogramo',
            'created_at' => Carbon::now()
        ]);
    }
}
