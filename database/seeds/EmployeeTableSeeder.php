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
        $limit = 50;

        Schema::disableForeignKeyConstraints();
        DB::table('employees')->truncate();
        factory(App\Employee::class, $limit )->create();

        for ($i = $limit; $i >= 1; $i--) {
            if ($i <= 50) $pos = 4;
            if ($i < 38) $pos = 3;
            if ($i < 28) $pos = 2;
            if ($i < 16) $pos = 1;

            DB::table('employees')->where('id', $i)
                ->update([
                    'position_id' => $pos,
                    'scale_number' => $i
                    ]
                );
        }
        $fakeEmail = Employee::find(1);
        $fakeEmail->update(['name' => 'admin', 'role_id' => 1]);
        $fakeEmail = Employee::find(2);
        $fakeEmail->update(['name' => 'usuario' ]);
         

        Schema::enableForeignKeyConstraints();
    }


}
