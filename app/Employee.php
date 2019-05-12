<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    public function absences()
    {
        return $this->hasMany(Absence::class);
    } 
    public function turns()
    {
        return $this->hasMany(Turn::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
