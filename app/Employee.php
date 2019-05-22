<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{


    protected $fillable = [
        'scale_number',
        'name', 
        'surname', 
        'dni', 
        'cip_code',
        'email'
    ];
    
    public function absences()
    {
        /* $this->absences = $this->hasMany(Absence::class);
        return $this->absences; */
        return $this->hasMany(Absence::class);
      
    }
    public function employee_tasks()
    {
        $this->employee_tasks = $this->hasMany(EmployeeTask::class);
        return $this->employee_tasks;
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
