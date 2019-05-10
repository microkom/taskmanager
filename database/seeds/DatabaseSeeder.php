<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployeeTableSeeder::class);
        $this->call(RankTableSeeder::class);
        $this->call(TaskTableSeeder::class);
        $this->call(EmployeeTaskTableSeeder::class);
        $this->call(AbsenceTableSeeder::class);
        $this->call(TurnTableSeeder::class);
    }
}
