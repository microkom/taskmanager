<?php

use Illuminate\Database\Seeder;
use App\RoleUser;
class RoleUserTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    
    public function run()
    {
        
        $arrayRoleUsers = [
            ["id" => 1, "user_id" => "1", "role_id" => 1 ],
            ["id" => 2, "user_id" => "2", "role_id" => 5 ],
            ["id" => 3, "user_id" => "3", "role_id" => 2 ],
        ];
        
             Schema::disableForeignKeyConstraints();
        DB::table('role_users')->truncate();
        foreach ($arrayRoleUsers as $role) {
            $data = new RoleUser;
            //dd(new RoleUser);
            $data->id = $role['id'];
            $data->role_id = $role['role_id'];
            $data->user_id = $role['user_id'];
            $data->save();
        } 
        Schema::enableForeignKeyConstraints();
       
        
    }
}