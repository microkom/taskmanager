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
        ["id" => 1, "task_id" => "1", "employee_id" => "1","position_id" => 1, "date_time" => "2019/6/27", "record_counter" => "5" ],
        ["id" => 2, "task_id" => "1", "employee_id" => "2","position_id" => 1, "date_time" => "2019/6/27", "record_counter" => "2" ],
        ["id" => 3, "task_id" => "1", "employee_id" => "3","position_id" => 1, "date_time" => "2019/6/27", "record_counter" => "3" ],
        ["id" => 4, "task_id" => "1", "employee_id" => "6","position_id" => 1, "date_time" => "2019/6/27", "record_counter" => "5" ],
        ["id" => 5, "task_id" => "1", "employee_id" => "5","position_id" => 1, "date_time" => "2019/6/27", "record_counter" => "1" ],
        ["id" => 6, "task_id" => "1", "employee_id" => "6","position_id" => 1, "date_time" => "2019/6/30", "record_counter" => "4" ],
        ["id" => 7, "task_id" => "1", "employee_id" => "7","position_id" => 1, "date_time" => "2019/6/27", "record_counter" => "3"]

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
