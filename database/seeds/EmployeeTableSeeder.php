<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $arrayEmployee = [
        ["id" => 1, "position_id" => "1"],
        ["id" => 2, "position_id" => "1"],
        ["id" => 3, "position_id" => "1"],
        ["id" => 4, "position_id" => "2"],
        ["id" => 5, "position_id" => "2"],
        ["id" => 6, "position_id" => "2"]
    ];

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        factory(App\Employee::class, 50)->create();
        Schema::enableForeignKeyConstraints();




    }
}
