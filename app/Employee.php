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
        'email',
        'active'
    ];
    
    public function absences()
    {
        /* $this->absences = $this->hasMany(Absence::class);
        return $this->absences; */
        return $this->hasMany(Absence::class);
      
    }
    public function employee_tasks()
    {
        return $this-> hasMany(EmployeeTask::class);
        
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    } 
    public function user()
    {
        return $this->hasOne(User::class);
    }
     public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
