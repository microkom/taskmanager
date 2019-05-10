<?php

use Illuminate\Database\Seeder;
use App\Turn;
class TurnTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    
    
    private $arrayTurns = [
        ['id' => 1,  'employee_id' => 36, 'task_id' => 3, 'turn' => 1, 'date_time' => '2019-04-16 00:00:00'],
        ['id' => 2,  'employee_id' => 41, 'task_id' => 3, 'turn' => 2, 'date_time' => '2019-04-24 00:00:00'],
        ['id' => 3,  'employee_id' => 12, 'task_id' => 1, 'turn' => 1, 'date_time' => '2019-04-01 00:00:00'],
        ['id' => 4,  'employee_id' => 30, 'task_id' => 1, 'turn' => 4, 'date_time' => '2019-04-24 00:00:00'],
        ['id' => 5,  'employee_id' => 26, 'task_id' => 3, 'turn' => 1, 'date_time' => '2019-04-15 00:00:00'],
        ['id' => 6,  'employee_id' => 12, 'task_id' => 1, 'turn' => 2, 'date_time' => '2019-05-01 00:00:00'],
        ['id' => 7,  'employee_id' => 27, 'task_id' => 3, 'turn' => 1, 'date_time' => '2019-04-28 00:00:00'],
        ['id' => 8,  'employee_id' => 39, 'task_id' => 2, 'turn' => 1, 'date_time' => '2019-05-06 00:00:00'],
        ['id' => 9,  'employee_id' => 44, 'task_id' => 3, 'turn' => 2, 'date_time' => '2019-04-28 00:00:00'],
        ['id' => 10, 'employee_id' => 20, 'task_id' => 1, 'turn' => 1, 'date_time' => '2019-04-28 00:00:00'],
        ['id' => 11, 'employee_id' => 24, 'task_id' => 3, 'turn' => 2, 'date_time' => '2019-04-30 00:00:00'],
        ['id' => 12, 'employee_id' => 16, 'task_id' => 1, 'turn' => 2, 'date_time' => '2019-04-22 00:00:00'],
        ['id' => 13, 'employee_id' => 14, 'task_id' => 1, 'turn' => 4, 'date_time' => '2019-05-09 00:00:00'],
        ['id' => 14, 'employee_id' => 4,  'task_id' => 4, 'turn' => 1, 'date_time' => '2019-04-29 00:00:00'],
        ['id' => 15, 'employee_id' => 2,  'task_id' => 3, 'turn' => 1, 'date_time' => '2019-05-07 00:00:00'],
        ['id' => 16, 'employee_id' => 29, 'task_id' => 3, 'turn' => 4, 'date_time' => '2019-04-25 00:00:00'],
        ['id' => 17, 'employee_id' => 16, 'task_id' => 1, 'turn' => 3, 'date_time' => '2019-05-04 00:00:00'],
        ['id' => 18, 'employee_id' => 11, 'task_id' => 1, 'turn' => 2, 'date_time' => '2019-05-06 00:00:00'],
        ['id' => 19, 'employee_id' => 1,  'task_id' => 4, 'turn' => 4, 'date_time' => '2019-04-17 00:00:00'],
        ['id' => 20, 'employee_id' => 6,  'task_id' => 3, 'turn' => 2, 'date_time' => '2019-05-07 00:00:00']
    ];
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('turns')->truncate();
        foreach ($this->arrayTurns as $turn) {
            $data = new Turn();
            $data->id = $turn['id'];
            $data->employee_id = $turn['employee_id'];
            $data->task_id = $turn['task_id'];
            $data->turn = $turn['turn'];
            $data->date_time = $turn['date_time'];
            $data->save();
        }
        Schema::enableForeignKeyConstraints();
    }
}