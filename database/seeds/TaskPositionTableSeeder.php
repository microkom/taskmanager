<?php

use Illuminate\Database\Seeder;
use App\TaskPosition;

class TaskPositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
        private $arrayTaskPositions = [
        ["id" => 1, "task_id" => 1, "position_id" => "1" ],
        ["id" => 2, "task_id" => 1, "position_id" => "2" ],
        ["id" => 3, "task_id" => 1, "position_id" => "3" ],
        ["id" => 4, "task_id" => 2, "position_id" => "1" ],
        ["id" => 5, "task_id" => 2, "position_id" => "2" ],
        ["id" => 6, "task_id" => 2, "position_id" => "3" ],
        ["id" => 7, "task_id" => 3, "position_id" => "1" ],
        ["id" => 8, "task_id" => 3, "position_id" => "2" ],
        ["id" => 9, "task_id" => 4, "position_id" => "1" ],
        ["id" => 10, "task_id" => 4, "position_id" => "2" ]

    ];
    public function run()
	{
		Schema::disableForeignKeyConstraints();
		DB::table('task_positions')->truncate();
		foreach ($this->arrayTaskPositions as $item) {
			$data = new TaskPosition();
			$data->id = $item['id'];
			$data->task_id = $item['task_id'];
			$data->position_id = $item['position_id'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
