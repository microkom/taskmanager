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



    public function run()
    {
        Schema::disableForeignKeyConstraints();
        factory(App\Employee::class, 50)->create();

        for ($i = 50; $i >= 1; $i--) {
            if ($i <= 50) $pos = 4;
            if ($i < 38) $pos = 3;
            if ($i < 28) $pos = 2;
            if ($i < 16) $pos = 1;

            DB::table('employees')->where('id', $i)
                ->update(
                    ['position_id' => $pos]
                );
        }

        Schema::enableForeignKeyConstraints();
    }


}
