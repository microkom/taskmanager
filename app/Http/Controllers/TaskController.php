<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use App\Absence;
use App\Employee;
use App\Turn;
use App\Task;
use App\Position;
use App\TaskPosition;
use App\EmployeeTask;

define("GUARDIA_DIA",   "1");
define("GUARDIA_FEST",  "2");

class TaskController extends Controller
{
    /*********************************************************
    * Defines the task to be done
    * @param $request Info received through post
    * @return
    */
    public function addTask(Request $request)
    {
        
        
        if(! $request-> position >0 ){
            //dump('value');
            $task = Task::all();
            
            return view('assignTask', ['tasks' => $task], ['error' => 'You should select a position']);
            
        }
        
        
        $date = $request->date;
        $task_id = $request->task;
        $quantity = $request->quantity;
        $position_id = $request->position;
        
        
        
        
        /**
        * Counter for the tasks added
        */
        
        $counter = 0;
        
        
        for ($i=0; $i < $quantity; $i++) {
            
            \Session::put('counter', $counter); 
            
            
            /**
            * Gets a list of all the people available for doing the task on the specified date
            */
            
            $employee_id_arr = $this-> whoIsPresent($date, $position_id, $task_id);
            
            
            /**
            * Error control for employees present.
            * If no one is available for the date requested this kicks in.
            */
            
            if (empty($employee_id_arr)) { 
                
                $task = Task::all();
                
                return view('assignTask', ['tasks' => $task], ['error' => 'There are no employees available on that date']);
                
            }else{
                
                /**
                * Saving data in the database * * * * * * * * * * * * * * * * * * * 
                */
                
                
                /**
                * Get the records of the tasks that have carried out the employees
                */
                
                $employee_record = $this-> getRecords($task_id, $position_id, $employee_id_arr);
                
                
                $data = new EmployeeTask();
                
                $data->task_id = $task_id;
                
                $data->employee_id = $employee_record[ 'employee_id'];
                
                $data->position_id = $position_id;
                
                $data->date_time = new Carbon($date);
                
                $data->record_counter =  $employee_record['next_record'];
                
                $data->save();
                
                $counter++;
            }
        }
        
        $task = Task::all();
        $today_tasks = $this->show_today_tasks_ajax();
        $today_tasks = collect($today_tasks);
        
        return view('assignTask', ['tasks' => $task, 'counter' => $counter, 'today_tasks' => $today_tasks]);
        
    }
    
    /*********************************************************
    * Order collection according to task
    * @param $data array containing [array of id of employees, task_id]
    * @return $employees collection of employees ordered
    */
    
    public function orderAccordingToTask($ids,  $task_id)
    {
        foreach ( $ids as  $id) {
            
            $employee[] = DB::table('employees')->find( $id);
        }
        
        //The $variable has to be coverted to collection
        $employee = collect( $employee);
        
        switch ( $task_id) {
            
            case 'GUARDIA_DIA':
            
            case 'GUARDIA_FEST':{
                
                $employees = $employee->sortByDesc('scale_number');
            }            
            break;
            
            default:{
                
                $employees = $employee->sortBy( 'scale_number');
            }            
            break;
        }
        
        return ($employees);
    }
    
    /*********************************************************
    *  Lowest count record of an employee per task
    * @param $task_id Id of the task
    * @param $position_id Position for that specific task
    * @param $employee
    * @return $min_turn array returning [id, min_turn]
    */
    public function getRecords($task_id, $position_id, $employee_ids)
    {
        
        $employee = $this-> orderAccordingToTask( $employee_ids,  $task_id);
        $employee = collect( $employee);
        //Count tasks done in that position -> it means the table may have no record of the task being ever done.
        //dump('no employee');
        if(!$employee->isEmpty()) //dump($employee); 
        $isThereATaskDoneInThisPosition = EmployeeTask::where('task_id',$task_id)->where('position_id', $position_id)->count();
        //dump('isThereATaskDoneInThisPosition');
        if( $isThereATaskDoneInThisPosition ){
            //dump($isThereATaskDoneInThisPosition);
            
            //Count employees who have zero record on a task -> checking those who are available for the task
            foreach ($employee as $key => $objectEmployee) {
                if (EmployeeTask::where('employee_id', $objectEmployee->id)->where('task_id', $task_id)->where('record_counter', '>', 0)->exists()) {
                    $employeesWithRecordOnTask[] = $objectEmployee->id;
                    
                    /**
                    * Get highest record of task / employee
                    * since the task has been done at least once, it is needed to capture the
                    * highest task count record for each employee in order to add 1 later
                    *
                    * 1- list of all the employees who are available based on position for the task
                    * 2- get the highest record of each employee
                    * 3- get a list of all the lowest
                    * 4- take the first one and add +1 to their  record
                    */
                    
                    
                    $max_record_counter = DB::table('employee_tasks')->where('task_id', $task_id)->where('employee_id', $objectEmployee->id)->max('record_counter');
                    
                    //array = [employee_id => max_record_counter_per_task_per_employee]
                    $max_record_of_each_employee[$objectEmployee->id] =  $max_record_counter;
                    
                } else {
                    
                    $employeesWithZeroRecordOnTask[] =  $objectEmployee->id;
                    
                }
            }
            
            
            /**
            *  Employees with zero record on the task
            *  the task has been done at least one by somedody, but this list gets one person in the same position who hasn't done it ever
            * */
            
            if(isset($employeesWithZeroRecordOnTask)){
                
                $first_employee_id = collect($employeesWithZeroRecordOnTask)->first();
                
                $next_record = [ 'employee_id' => $first_employee_id, 'next_record'=> 1];
                
            } else {
                
                $tmp_record = 99999999999999;
                
                foreach ($max_record_of_each_employee as $employee_id => $max_record) {
                    
                    if($max_record < $tmp_record){
                        
                        $employee_for_task_id = $employee_id ;
                        
                        $employee_for_task_max_record = $max_record;
                        
                        $tmp_record = $max_record;
                        
                    }
                }
                
                $next_record = [ 'employee_id' => $employee_for_task_id, 'next_record' => $employee_for_task_max_record + 1 ];
            }
        }else{
            $next_record = [ 'employee_id' => $employee->first()->id, 'next_record' => 1];
        }
        
        return $next_record;
    }
    
    
    /*********************************************************
    * Employees available for task
    * @param $date The date to carry out the task
    * @param $position_id The position of the employee required for the task 
    * @param $task_id The task to be carried out
    * @return $id  List of IDs of employees present
    */
    protected function whoIsPresent($date, $position_id, $task_id)
    {
        /**
        * Get ids of all employees who are not available for the task
        */
        $id_absentees_obj = $this->_whoIsUnavailable( $date,$position_id, $task_id);
        //dump('id_absentees_obj'); //dump($id_absentees_obj);
        /**
        * get all employees in database within a $position_id
        */
        
        $all_employees_obj = DB::table('employees')->where('position_id', $position_id)->get();
        
        
        /**
        * Posible exit if there are no employees in this position
        */
        //dump('all employees'); dump($all_employees_obj);exit();
        if( !$all_employees_obj->count() > 0 ) return;
        
        
        /**
        * Return ids of employees. There are no absentees
        */
        
        if (!isset($id_absentees_obj)){
            
            /**
            * Extract employee ids
            */
            
            foreach ( $all_employees_obj as $itemId) {
                
                $id_arr[] = $itemId->id;
            }
            
            return $id_arr;
            
        }else{
            
            /**
            * Extract employee ids
            */
            
            foreach ($all_employees_obj as $employee) {
                
                $id_employees_arr[] = $employee->id;
            }
            
            //idAbseentees is interpreted as object, it needs to be converted to array
            
            foreach ( $id_absentees_obj as $objectID) {
                
                $id_absents_arr[] = $objectID;
            }
            
            
            $id_arr = array_values(array_diff($id_employees_arr, $id_absents_arr));
            
            return $id_arr ;
        }
    }
    
    
    /*********************************************************
    * Returns the absent people on that specific date
    * @param $date Absence date
    * @param $position_id
    * @param task_id
    * @return Collection of employees
    */
    protected function _whoIsUnavailable($date, $position_id, $task_id)
    {   
        /**
        * convert received date to Carbon format
        */
        $carbonDate = new Carbon($date);
        
        $beforeDutyDate = $carbonDate->subDay();
        /**
        * Filter employees who are absent
        */
         $abss = Absence::where('start_date_time', '<=', $carbonDate)->where('end_date_time', '>=', $carbonDate)->get();
        
        //extract employee ids
        
             foreach ($abss as $itemId) {
            
            $id[] = $itemId->employee_id;
        } 
        
        //filter employees doing a task on $date
         $onduty = EmployeeTask::where('date_time', '=', $carbonDate)->get();
        
        //extract employee ids
           foreach ( $onduty as $itemId) {
            $id[] = $itemId->employee_id;
        } 
        
        //filter employees who have a day off after task
        
         //  $beforeDutyDate = $carbonDate->subDay();
        
        $afterDuty = DB::table('employee_tasks')->where( 'date_time', '=', $beforeDutyDate)->where(function ($query) {
            
            $query->where( 'task_id', '=', 1)->orWhere( 'task_id', '=', 2);        
            
        })->get(); 
        
        
        //extract employee ids
        /*    foreach ( $afterDuty as $itemId) {
            $id[] = $itemId->employee_id;
        }
        */
        
        $employees = DB::table('employees')->where('position_id', $position_id)->get();
        
        if (\is_object($employees)){
            
            foreach ($employees as $employee_obj) {
                
                /**
                * Filter employees who are absent
                */
                
                $a = DB::table('absences')->
                where('start_date_time',    '<=',    $carbonDate)->
                where('end_date_time',      '>=',    $carbonDate)->
                where('employee_id',                 $employee_obj->id)->
                get();

                if(!$a->isEmpty()) $employee_obj->absence = $a;
                
                
                
                /**
                * filter employees doing a task on $date
                */
                
                $b = DB::table('employee_tasks')->
                where('employee_id',            $employee_obj->id)->
                where('date_time',      '=',    $carbonDate)->
                get();
                if(!$b->isEmpty()) $employee_obj->employee_on_duty = $b;
                
                /**
                * filter employees who have a day off after task
                */
                
                $c = DB::table('employee_tasks')->
                where('employee_id',            $employee_obj->id)->
                where( 'date_time',     '=',    $beforeDutyDate)->
                where(function ($query) {
                    $query->
                    where(   'task_id', '=', 1)->
                    orWhere( 'task_id', '=', 2);        
                    
                })->get();

                if(!$c->isEmpty()) $employee_obj->employee_day_off = $c;
            }
        }
        //dump('employee');dump($employees);exit();
        
        //exit();
        /**
        * No value to send
        */
        
        if (!isset($id)){
            
            return ;
            
        }else{
            
            $uniqueIds = array_unique($id);
            
            $uniqueIds = array_values($uniqueIds);
            
            return $uniqueIds;
        }           
        
    }
    
    
    /*********************************************************
    * Query database task_positions for each Task through ajax
    * @param $request Info received through post
    * @return $data JSON file containing the positions specific to a task
    */
    public function positions_ajax(Request $request)
    {
        $task_positions = TaskPosition::all()->where('task_id', $request->task_id);
        
        foreach ($task_positions as $position) {
            
            $data[] = ['id' => $position->position_id, 'name' => Position::findOrFail($position->position_id)->name];
        }
        return response()->json($data);
    }
    
    
    
    /*********************************************************
    * Query database today's Tasks through ajax
    * @param $request Info received through post
    * @return $data JSON file containing today's task
    */
    protected function show_today_tasks_ajax()
    {
        $tdate = new Carbon(date("Y-m-d"));
        
        $today_tasks = DB::table('employee_tasks')->where('date_time','>=',$tdate)->get();
        
        
        foreach ($today_tasks as $task) {
            
            $data[] = [
                'id' => $task->id, 
                'employee' =>   Employee::  findOrFail    ($task->employee_id)->name.' '.Employee::  findOrFail    ($task->employee_id)->surname,
                'task' =>       Task::      findOrFail    ($task->task_id)->name,
                'position' =>   Position::  findOrFail    ($task->position_id)->name,
                'date' => $task->date_time];
        }
        if(!isset($data)){ 
           return ; 
        }

        return $data;
    }
    
    
    
    /*********************************************************
    * Get all tasks from the database
    * @return tasks[] array of all the tasks in the database
    */
    
    public function landing()
    {
        $task = Task::all();
        
        
        $today_tasks = $this->show_today_tasks_ajax();
        $today_tasks = collect($today_tasks);
        //$request->session()->flash('alert-success', 'User was successful added!');
        return view('assignTask', ['tasks' => $task,'today_tasks' => $today_tasks]);
    }
    
}
