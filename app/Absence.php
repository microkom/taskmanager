<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{

    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }
}
