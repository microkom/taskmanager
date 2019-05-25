<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\User;

class EmployeeTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */



    public function run()
    {   
        $limit = 32;

        Schema::disableForeignKeyConstraints();
        DB::table('employees')->truncate();
        factory(App\Employee::class, $limit )->create();

        for ($i = $limit; $i >= 1; $i--) {
            if ($i <= 50) $pos = 4;
            if ($i < 38) $pos = 3;
            if ($i < 28) $pos = 2;
            if ($i < 16) $pos = 1;

            DB::table('employees')->where('id', $i)
                ->update(
                    ['position_id' => $pos]
                );
        }
        $fakeEmail = Employee::find(1);
        $fakeEmail->update(['name' => 'admin', 'email' => 'admin@gmail.com']);
        $fakeEmail = Employee::find(2);
        $fakeEmail->update(['name' => 'usuario','email' => 'usuario@gmail.com']);
        
        factory(App\User::class, $limit)->create();

        Schema::enableForeignKeyConstraints();
    }


}
