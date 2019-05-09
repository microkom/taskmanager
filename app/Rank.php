<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
