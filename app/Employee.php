<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{

    public $id;
    public $position_id;
    public $scale_number;
    public $dni;
    public $name;
    public $surname;
    public $cip_code;
    public $email;
    public $email_verified_at;
    public $password;
    public $remember_token;
    public $created_at;
    public $updated_at;
    public $absence ;
    public $employee_on_duty;
    public $employee_day_off;


    
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
