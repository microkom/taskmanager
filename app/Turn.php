<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function filtro()
    {
        return $this->belongsTo(Employee::class);
    }
}
