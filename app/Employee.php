<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
    public function employeeTasks()
    {
        return $this->hasMany(EmployeeTask::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
