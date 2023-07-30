<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lab_measures')->insert([
            'measure_name' => 'white blood cells',
            'warning_below' => 4500,
            'warning_after' => 11500
        ]);

        DB::table('lab_measures')->insert([
            'measure_name' => 'red blood cells',
            'warning_below' => 4500,
            'warning_after' => 11500
        ]);

        DB::table('lab_measures')->insert([
            'measure_name' => 'prothrombin time',
            'warning_below' => 11,
            'warning_after' => 13.5
        ]);

        DB::table('lab_measures')->insert([
            'measure_name' => 'activated partial thromboplastin',
            'warning_below' => 11,
            'warning_after' => 13.5
        ]);
    }
}
