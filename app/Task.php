<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     public function turns()
    {
        return $this->hasMany(Turn::class);
    }
}
