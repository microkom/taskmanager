<?php

use Illuminate\Database\Seeder;
use App\Rank;

class RankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $arrayRanks = [
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
		DB::table('ranks')->truncate();
		foreach ($this->arrayRanks as $rank) {
			$data = new Rank();
			$data->id = $rank['id'];
			$data->name = $rank['name'];
			$data->save();
		}
		Schema::enableForeignKeyConstraints();
	}
}
