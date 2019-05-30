<?php
use Faker\Generator as Faker;
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
    public function run(Faker $faker)
    {
        $emp = Employee::all();
        
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
         foreach ($emp as $user) {
            $data = new User;
            $data->employee_id = $user->id;
            $data->name = $user->name;
            $data->email = $faker->email;
            $data->password = '$2y$10$fVUc2cSubCmXvYxcSgGpQOb.l4MhHHU79e4Xllg792GRTjlQt0IOy';
            $data->save();
            //factory(App\User::class, 50)->create();
        } 
                $fakeEmail = User::find(1);
        $fakeEmail->update([  'email' => 'admin@gmail.com' ]);
        $fakeEmail = User::find(2);
        $fakeEmail->update([ 'email' => 'usuario@gmail.com' ]);

        Schema::enableForeignKeyConstraints();
    }
}
