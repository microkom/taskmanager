<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
        $date = $request->date;
        $task_id = $request->task;
        $quantity = $request->quantity;
        $position_id = $request->position;
        
        for ($i=0; $i < $quantity; $i++) {
            
            $employee = $this-> whoIsPresent($date, $position_id, $task_id);
            
            $employee_record = $this-> getRecords($task_id, $position_id, $employee);
            
            $data = new EmployeeTask();
            $data->task_id = $task_id;
            $data->employee_id = $employee_record[ 'employee_id'];
            $data->position_id = $position_id;
            $data->date_time = new Carbon($date);
            $data->record_counter =  $employee_record['min_record'];
            $data->save();
            
        }
        
        $task = Task::all();
        return view('assignTask', ['tasks' => $task]);
        
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
        $employee = collect( $employee);
        
        //$employee = json_decode( json_decode($employee, true), true);
        
        //dump( 'orderAccordingToTask($employee)');
        //dump ( $employee );
        
        switch ( $task_id) {
            case '1':
            case '2':
            $employees = $employee->sortByDesc('scale_number');
            break;
            default:
            $employees = $employee->sortBy( 'scale_number');
            break;
        }
        //dump('order');
        //dump($employees);
        return ($employees);
    }
    
    /*********************************************************
    *  Lowest record of a task
    * @param $task_id Id of the task
    * @param $position_id Position for that specific task
    * @param $employee 
    * @return $min_turn array returning [id, min_turn]
    */
    public function getRecords($task_id, $position_id, $employee)
    {
        
        $employee = $this-> orderAccordingToTask( $employee,  $task_id);
        $employee = collect( $employee);
        //dump('employee at orderAccordingToTask()');
        //dump($employee );
        
        //Count tasks done in that position -> it means the table has no record of the task being ever done.
        $taskCounterPerPosition = EmployeeTask::where('task_id',$task_id)->where('position_id', $position_id)->count();
        //dump('taskCounterPerPosition');
        if( $taskCounterPerPosition ){
            //dump($taskCounterPerPosition);
            
            //Count employees who have zero record on a task -> checking those who are available for the task
            foreach ($employee as $key => $objectEmployee) {
                if (EmployeeTask::where('employee_id', $objectEmployee->id)->where('task_id', $task_id)->where('record_counter', '>', 0)->exists()) {
                    $employeesWithRecordOnTask[] = $objectEmployee->id;
                    
                    /**
                    * Get highest record of task / employee
                    * since the task has been done at least once, it is needed to capture the
                    * highest task count record for each employee
                    *
                    * 1- list of all the employees based on rank for the task who are available
                    * 2- get the highest record of each employee
                    * 3- get a list the all the lowest
                    * 4- take the first one and add +1 to their  record
                    */
                    
                    //foreach ($employeesWithRecordOnTask as $idEmployee) {
                        $max_record_counter = DB::table('employee_tasks')->where('task_id', $task_id)->where('employee_id', $objectEmployee->id)->max('record_counter');
                        
                        //array = [employee_id => max_record_counter_per_task_per_employee]
                        $max_record_of_each_employee[$objectEmployee->id] =  $max_record_counter;
                        
                        //}
                    } else {
                        $employeesWithZeroRecordOnTask[] =  $objectEmployee->id;
                    }
                }
                
                //dump('employeesWithRecordOnTasks-counter');
                if(isset($employeesWithRecordOnTask)){
                    //dump(( $employeesWithRecordOnTask));
                }
                //$employeesWithZeroRecordOnTask = null;
                
                /**
                *  Employees with zero record on the task
                *  the task has been done at least one by somedody, but this list gets one person in the same position who hasn't done it ever
                * */
                
                if(isset($employeesWithZeroRecordOnTask)){
                    
                    $first_employee_id = collect($employeesWithZeroRecordOnTask)->first();
                    
                    $min_record = [ 'employee_id' => $first_employee_id, 'min_record'=> 1];
                    
                } else {

                    //dump('max_record_of_each_employee');
                    //dump($max_record_of_each_employee);

                    $tmp_record = 99999999999999;
                    foreach ($max_record_of_each_employee as $employee_id => $max_record) {
                        if($max_record < $tmp_record){
                            $employee_for_task_id = $employee_id ;
                            $employee_for_task_max_record = $max_record;
                            $tmp_record = $max_record;
                        }
                    }
                    //dump('min record');
                    //dump($tmp_record);
                    //dump($employee_for_task_max_record);
                    //dump($employee_for_task_id);
                    // exit();

                    /* $min_record_among_employees_task = EmployeeTask::where('task_id', $task_id)->where('employee_id', $employeesWithRecordOnTask[0])->min('record_counter');
                    $employee_task_min_record = EmployeeTask::where('task_id', $task_id)->where('employee_id', $employeesWithRecordOnTask[0])->min('record_counter');
                    
                    //dump('$min_record_in_task_position');
                    //dump($min_record_in_task_position);
                    
                    //get employee with that same $min_record_in_task_position
                    foreach ( $employeesWithRecordOnTask as  $employee) {
                        if( EmployeeTask::where('task_id', $task_id)->where('employee_id', $employee)->max('record_counter') == $min_record_in_task_position){
                            $id_min_record[] = $employee;
                        }
                    }
                    //dump('employees with the same $min_record, get the first ');// if there are not enough employees error on dev, control it
                    //dump( $id_min_record); */
                    $min_record = [ 'employee_id' => $employee_for_task_id, 'min_record' => $employee_for_task_max_record + 1 ];
                }
            }else{
                $min_record = [ 'employee_id' => $employee->first()->id, 'min_record' => 1];
            }
            //exit();
            return $min_record;
        }
        
        
        /*********************************************************
        * Employees available for task
        * @param $date
        * @param $position_id
        * @param $task_id
        * @return $id  List of IDs of employees present
        */
        protected function whoIsPresent($date, $position_id, $task_id)
        {
            $idAbsentees = $this->_whoIsUnavailable( $date,$position_id, $task_id);
            
            //dump('idabsentees');
            //dump( $idAbsentees);
            
            //get all employees in database filtering $position_id
            $allEmployees = Employee::all()->where('position_id', $position_id);
            
            //dump( 'allEmployees');
            //dump( $allEmployees);
            //exit();
            
            //return ids of employees. There are no absentees
            if (!isset($idAbsentees)){
                
                //extract employee ids
                foreach ( $allEmployees as $itemId) {
                    $id[] = $itemId->id;
                }
                return $id;
            }else{
                //extract ids
                foreach ($allEmployees as $employee) {
                    $idEMployees[] = $employee->id;
                }
                
                //idAbseentees is interpreted as object, it needs to be converted to array
                foreach ( $idAbsentees as $objectID) {
                    $idAbsent[] = $objectID;
                }
                
                $id = array_diff($idEMployees, $idAbsent);
                
                return array_values($id);
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
            //convert received date to Carbon format
            $carbonDate = new Carbon($date);
            
            //filter absentees
            $absences = Absence::
            where('start_date_time', '<=', $carbonDate)->
            where('end_date_time',   '>=', $carbonDate)->
            get();
            
            //extract employee ids
            foreach ($absences as $itemId) {
                $id[] = $itemId->employee_id;
                $employee = ['id' => $itemId->employee_id, 'absent' => true];
                $data[] = ['employee' =>$employee];
            }
            
            
            //filter employees doing a task on $date
            $onduty = EmployeeTask::where('date_time', '=', $carbonDate)->get();
            
            //extract employee ids
            foreach ( $onduty as $itemId) {
                $id[] = $itemId->employee_id;
            }
            
            //filter employees who have a day off after task
            
            $beforeDutyDate = $carbonDate->subDay();
            
            $afterDuty = DB::table('employee_tasks')
            ->where( 'date_time', '=', $beforeDutyDate)
            ->where(function ($query) {
                $query->where( 'task_id', '=', 1)
                ->orWhere( 'task_id', '=', 2);        })
                ->get();
                
                //extract employee ids
                foreach ( $afterDuty as $itemId) {
                    $id[] = $itemId->employee_id;
                }
                
                //no value to send
                if (!isset($id)){
                    return ;
                }else{
                    $uniqueIds = array_unique($id);
                    $uniqueIds = array_values($uniqueIds);
                    return $uniqueIds;
                }
                
                
            }
            
            
            /*********************************************************
            * Query database Positions for each Task through ajax
            * @param $request Info received through post
            * @return $data JSON file containing the positions specific to a task
            */
            public function positions_ajax(Request $request)
            {
                $positions = TaskPosition::all()->where('task_id', $request->task_id);
                
                foreach ($positions as $key => $position) {
                    
                    $data[] = ['id' => $position->position_id, 'name' => Position::findOrFail($position->position_id)->name];
                }
                return response()->json($data);
            }
            
            /*********************************************************
            * Query database task
            * @return tasks[] array of all the tasks in the database
            */
            public function landing()
            {
                $task = Task::all();
                return view('assignTask', ['tasks' => $task]);
            }
            
        }
        