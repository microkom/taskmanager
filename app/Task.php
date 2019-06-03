<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     protected $fillable = [
        'name', 
    ];
    
     public function positions()
    {
        return $this->belongsToMany('App\Position', 'task_positions' );
    }
}
