<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'lab',
        ]);

        DB::table('departments')->insert([
            'name' => 'consultation',
        ]);

        DB::table('departments')->insert([
            'name' => 'radiology',
        ]);
    }
}
