<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
     public function absences()
    {
        return $this->hasMany(Absence::class);
    } 
}
