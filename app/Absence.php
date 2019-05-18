<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
/*     public $id;
    public $employee_id;
    public $start_date_time;
    public $end_date_time;
    public $note;
    public $created_at;
    public $updated_at; */

    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }
}
