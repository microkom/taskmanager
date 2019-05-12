<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
