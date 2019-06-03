<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    
   protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

     public function tasks()
    {
        return $this->belongsToMany('App\Task', 'task_positions' );
    }
}
