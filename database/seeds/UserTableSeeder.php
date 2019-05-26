<?php

use App\User;
use App\Employee;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emp = Employee::all();

        Schema::disableForeignKeyConstraints();
		DB::table('users')->truncate();
        foreach ($emp as $user) {
            $data = new User;
            $data->name = $user->name;
            $data->email = $user->email;
            $data->password = '$2y$10$fVUc2cSubCmXvYxcSgGpQOb.l4MhHHU79e4Xllg792GRTjlQt0IOy';
            $data->save();
        }

        $employee = User::find(1);
        $employee->update(['role_id' => 1]);

        Schema::enableForeignKeyConstraints();
    }
}
