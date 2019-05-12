<?php

use Illuminate\Database\Seeder;
use App\Position;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $arrayPositions = [
        ["id" => 1, "name" => "Soldado" ],
        ["id" => 2, "name" => "Soldado de 1ª" ],
        ["id" => 3, "name" => "Cabo" ],
        ["id" => 4, "name" => "Cabo 1º" ],
        ["id" => 5, "name" => "Cabo Mayor" ],
        ["id" => 6, "name" => "Sargento" ],
    ];
    public function run()
	{
		Schema::disableForeignKeyConstraints();
		DB::table('positions')->truncate();
		foreach ($this->arrayPositions as $item) {
			$data = new Position();
			$data->id = $item['id'];
			$data->name = $item['name'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
