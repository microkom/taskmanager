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
        Schema::disableForeignKeyConstraints();

        $this->call(EmployeeTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(TaskTableSeeder::class);
        $this->call(TaskPositionTableSeeder::class);
        $this->call(EmployeeTaskTableSeeder::class);
        $this->call(AbsenceTableSeeder::class);
        
        Schema::enableForeignKeyConstraints();
    }
}
