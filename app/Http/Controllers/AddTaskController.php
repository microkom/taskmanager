<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absence;
use Carbon\Carbon;

class AddTaskController extends Controller
{
  /**
  * Defines the task to be done
  * @param 
  * @return 
  */
  public function addTask($date, $rank_id, $task_id)
  {
    //get all employees that will be absent on $date given
    $absentees = $this->whoIsAbsent($date);
  }
      
  /**
  * Returns the absent people on that specific date
  * 
  * @param $date Absence date
  * @return Collection of employees
  */
  protected function whoIsAbsent($date)
  {   
    //convert received date to Carbon format
    $carbonDate = new Carbon($date);  
    
    //filter absentees
    $absences = Absence::
      where('start_date_time', '<=', $carbonDate)->
      where('end_date_time',   '>=', $carbonDate)->
    get(); 
    
    //use id of absentees to get all info of employee
    foreach ($absences as $absence) {
      $employees[] = $absence->employee;
    }
    
    if(!isset($employees))return [-1, 'nobody is absent on '.$date];
    
    return $employees;
  }
}
