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
        $this->call(PositionTableSeeder::class);
        $this->call(TaskTableSeeder::class);
        $this->call(EmployeeTaskTableSeeder::class);
        $this->call(AbsenceTableSeeder::class);
        $this->call(TaskPositionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(UserTableSeeder::class);
       
    }
}
