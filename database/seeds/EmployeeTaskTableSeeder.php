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
        ["id" => 1, "task_id" => "1", "employee_id" => "1", "start_date_time" => "2019/5/7 09:00" ],
        ["id" => 2, "task_id" => "1", "employee_id" => "2", "start_date_time" => "2019/5/7 09:00" ],
        ["id" => 3, "task_id" => "1", "employee_id" => "3", "start_date_time" => "2019/5/7 09:00" ],
        ["id" => 4, "task_id" => "2", "employee_id" => "4", "start_date_time" => "2019/5/7 09:00" ],
        ["id" => 5, "task_id" => "1", "employee_id" => "5", "start_date_time" => "2019/5/7 09:00" ],
        ["id" => 6, "task_id" => "1", "employee_id" => "6", "start_date_time" => "2019/5/7 09:00" ]        
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
			$data->start_date_time = $te['start_date_time'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
