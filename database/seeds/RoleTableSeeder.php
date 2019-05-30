<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  
  private $arrayRoles = [
    ["id" => 1, "name" => "admin", "priority" => 1 ],
    /* ["id" => 2, "name" => "auxiliar", "priority" => 2 ],
    ["id" => 3, "name" => "suboficial", "priority" => 3 ],
    ["id" => 4, "name" => "escribiente", "priority" => 4 ], */
    ["id" => 2, "name" => "usuario", "priority" => 5 ]        
  ];
  
  public function run()
  {
    Schema::disableForeignKeyConstraints();
    DB::table('roles')->truncate();
    foreach ($this->arrayRoles as $roles) {
      $data = new Role();
      $data->id = $roles['id'];
      $data->name = $roles['name'];
      $data->priority = $roles['priority'];
      $data->save();
    }
    Schema::enableForeignKeyConstraints();
  }
}
