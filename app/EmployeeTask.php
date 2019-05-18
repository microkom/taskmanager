<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{

/*     public $id;
    public $task_id;
    public $employee_id;
    public $position_id;
    public $date_time;
    public $record_counter;
    public $created_at;
    public $updated_at; */

    public function task()
    {
        return $this-> belongsTo(Task::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
