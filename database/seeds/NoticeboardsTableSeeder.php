<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NoticeboardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        DB::table('noticeboards')->insert([
            ['id'=>1,'subject'=>'Meeting ','description'=>'Tomorrow there will be a meeting for all the doctors.','user_id'=>2,'time'=> '2020-02-02 09:01:01'],
            ['id'=>2,'subject'=>'Holiday','description'=>'Tomorrow will be a holiday for all the staff members.','user_id'=>2,'time'=> '2020-02-05 13:01:01'],
            ['id'=>3,'subject'=>'Meeting','description'=>'Tomorrow there will be a meeting for all the Members.','user_id'=>4,'time'=> '2020-02-12 09:01:01'],
            ['id'=>4,'subject'=>'Security','description'=>'Everyone should update their system passwords.','user_id'=>1,'time'=> '2020-02-17 09:01:01']
            ]);
        */
        
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
