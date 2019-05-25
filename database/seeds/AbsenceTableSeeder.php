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
        ["id" => 1, "employee_id" => 1, "start_date_time" => "2019/5/26 00:00:00", "end_date_time" => "2019/5/27 00:00:00"],
        ["id" => 2, "employee_id" => 2, "start_date_time" => "2019/5/27 00:00:00", "end_date_time" => "2019/5/30 00:00:00" ],
        ["id" => 3, "employee_id" => 4, "start_date_time" => "2019/5/27 00:00:00", "end_date_time" => "2019/5/27 00:00:00" ],
        ["id" => 4, "employee_id" => 6, "start_date_time" => "2019/5/27 00:00:00", "end_date_time" => "2019/5/27 00:00:00" ],
        ["id" => 5, "employee_id" => 3, "start_date_time" => "2019/5/31 00:00:00", "end_date_time" => "2019/5/31 00:00:00" ],
        ["id" => 6, "employee_id" => 6, "start_date_time" => "2019/5/31 00:00:00", "end_date_time" => "2019/5/31 00:00:00"]

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
