<?php

use Illuminate\Database\Seeder;
use App\EmployeeTask;
use App\Employee;

class EmployeeTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $arrayEmployeeTask = [
        ["id" => 1, "task_id" => "1", "employee_id" => "1","position_id" => 1, "date_time" => "2019/5/7 00:00", "record_counter" => "3" ],
        ["id" => 2, "task_id" => "1", "employee_id" => "2","position_id" => 1, "date_time" => "2019/5/7 00:00", "record_counter" => "5" ],
        ["id" => 3, "task_id" => "1", "employee_id" => "3","position_id" => 1, "date_time" => "2019/5/7 00:00", "record_counter" => "1" ],
        ["id" => 4, "task_id" => "2", "employee_id" => "4","position_id" => 1, "date_time" => "2019/5/27 00:00", "record_counter" => "3" ],
        ["id" => 5, "task_id" => "1", "employee_id" => "5","position_id" => 1, "date_time" => "2019/5/27 00:00", "record_counter" => "2" ],
        ["id" => 6, "task_id" => "1", "employee_id" => "6","position_id" => 1, "date_time" => "2019/5/31 00:00", "record_counter" => "3" ],
        ["id" => 7, "task_id" => "1", "employee_id" => "7","position_id" => 1, "date_time" => "2019/5/7 00:00", "record_counter" => "3"]

    ];
    public function run()
	{
		Schema::disableForeignKeyConstraints();
		DB::table('employee_tasks')->truncate();
		foreach ($this->arrayEmployeeTask as $te) {
			$data = new EmployeeTask();
			$data->id = $te['id'];
			$data->task_id = $te['task_id'];
            $data->employee_id = $te['employee_id'];
            $data->position_id = $te['position_id'];
            $data->date_time = $te['date_time'];
			$data->record_counter = $te['record_counter'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
