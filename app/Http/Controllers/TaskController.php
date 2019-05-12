<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Absence;
use App\Employee;
use App\Turn;
use App\Task;
use App\Position;
use App\TaskPosition;


class TaskController extends Controller
{
    /**
    * Defines the task to be done
    * @param 
    * @return 
    */
    public function assignTask(Request $request)
    {
        $date = $request->date;
        $position_id = $request->position_id;
        $task_id = $request->task_id;
        
        $present = $this->whoIsPresent($date);
        
        return $present;
    }
    
    
    /**
    * Query database task
    */
    public function landing()
    {
        $task = Task::all();
        return view('assignTask', ['tasks' => $task]);
    }
    
    /**
    * Query database Positions for each Task
    */
    public function positions_ajax(Request $request)
    {
        $positions = TaskPosition::all()->where('task_id', $request->task_id);
        
        foreach ($positions as $key => $position) {
            
            $data[] = ['id'=> $position->id, 'name'=> Position::find($position->position_id)->name];
        }
        return response()->json($data);
    }
    protected function whoIsPresent($date =0 )
    {
        $position_id = 1;                                               //simulated position received by parameter
        
        $absentees = $this->_whoIsAbsent($date);
        
        //filter employees who WILL BE PRESENT base on the those who will be absent
        foreach ($absentees as $key => $absent) {
            $employee[] = Employee::all()->where('id','<>',($absent->employee_id))->where('position_id', $position_id);   
        }
        //return $employee;
        // return view('assignTask', ['employee' => $employee]);
    }
    
    
    /**
    * Returns the absent people on that specific date
    * @param $date Absence date
    * @return Collection of employees
    */
    protected function _whoIsAbsent($date)
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
