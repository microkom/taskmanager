<?php

use Illuminate\Database\Seeder;
use App\Absence;
class AbsenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       private $arrayAbsences = [
        ["id" => 1, "employee_id" => 1, "start_date_time" => "2019/6/26", "end_date_time" => "2019/6/27"],
        ["id" => 2, "employee_id" => 2, "start_date_time" => "2019/6/27", "end_date_time" => "2019/6/30" ],
        ["id" => 3, "employee_id" => 4, "start_date_time" => "2019/6/27", "end_date_time" => "2019/6/27" ],
        ["id" => 4, "employee_id" => 6, "start_date_time" => "2019/6/27", "end_date_time" => "2019/6/27" ],
        ["id" => 5, "employee_id" => 3, "start_date_time" => "2019/6/30", "end_date_time" => "2019/6/30" ],
        ["id" => 6, "employee_id" => 6, "start_date_time" => "2019/6/30", "end_date_time" => "2019/6/30"]

    ];
    public function run()
	{
		Schema::disableForeignKeyConstraints();
		DB::table('absences')->truncate();
		foreach ($this->arrayAbsences as $absence) {
			$data = new Absence();
			$data->id = $absence['id'];
			$data->employee_id = $absence['employee_id'];
			$data->start_date_time = $absence['start_date_time'];
			$data->end_date_time = $absence['end_date_time'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
