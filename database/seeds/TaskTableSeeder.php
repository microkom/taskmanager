<?php

use Illuminate\Database\Seeder;
use App\Task;
class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       private $arrayTasks = [
        ["id" => 1, "name" => "Guardia L/V", "duration" => "24:00:00"],
        ["id" => 2, "name" => "Guardia S, D, Fs", "duration" => "24:00" ],
        ["id" => 3, "name" => "Conductor Ambulancia", "duration" => "8:00" ],
        ["id" => 4, "name" => "Limpieza HQ", "duration" => "6:00" ]
        
    ];
    public function run()
	{
		Schema::disableForeignKeyConstraints();
		DB::table('tasks')->truncate();
		foreach ($this->arrayTasks as $task) {
			$data = new Task();
			$data->id = $task['id'];
			$data->name = $task['name'];
			$data->duration = $task['duration'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
