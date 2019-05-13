<?php

use Illuminate\Database\Seeder;
use App\EmployeeTask;
class EmployeeTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $arrayEmployeeTask = [
        ["id" => 1, "task_id" => "1", "employee_id" => "1", "date_time" => "2019/5/7 09:00", "record_counter" => "0" ],
        ["id" => 2, "task_id" => "1", "employee_id" => "2", "date_time" => "2019/5/7 09:00", "record_counter" => "0" ],
        ["id" => 3, "task_id" => "1", "employee_id" => "3", "date_time" => "2019/5/7 09:00", "record_counter" => "0" ],
        ["id" => 4, "task_id" => "2", "employee_id" => "4", "date_time" => "2019/5/7 09:00", "record_counter" => "0" ],
        ["id" => 5, "task_id" => "1", "employee_id" => "5", "date_time" => "2019/5/7 09:00", "record_counter" => "0" ],
        ["id" => 6, "task_id" => "1", "employee_id" => "6", "date_time" => "2019/5/7 09:00", "record_counter" => "0" ]
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
            $data->date_time = $te['date_time'];
			$data->record_counter = $te['record_counter'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
