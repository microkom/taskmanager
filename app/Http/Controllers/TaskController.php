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
            dump('value');
            $task = Task::all();

            return view('assignTask', ['tasks' => $task], ['error' => 'You should select a position']);

        }exit();


        $date = $request->date;
        $task_id = $request->task;
        $quantity = $request->quantity;
        $position_id = $request->position;




        $counter = 0;

        \Session::put('counter', $counter);

        for ($i=0; $i < $quantity; $i++) {

            \Session::put('counter', $counter); //count tasks added

            $employee_ids = $this-> whoIsPresent($date, $position_id, $task_id);

            /**
            * Error control for employees present.
            * If no one is available for the date requested this kicks in.
            */
            if (empty($employee_ids)) {

                $task = Task::all();

                return view('assignTask', ['tasks' => $task], ['error' => 'There are no employees available on that date']);

            }else{
                //save data in database
                $employee_record = $this-> getRecords($task_id, $position_id, $employee_ids);

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
        return view('assignTask', ['tasks' => $task, 'counter' => $counter]);

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
    public function getRecords($task_id, $position_id, $employee_ids)
    {

        $employee = $this-> orderAccordingToTask( $employee_ids,  $task_id);
        $employee = collect( $employee);
        //dump('employee at orderAccordingToTask()');
        //dump($employee );

        //Count tasks done in that position -> it means the table may have no record of the task being ever done.
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

                    $next_record = [ 'employee_id' => $first_employee_id, 'next_record'=> 1];

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

                    $next_record = [ 'employee_id' => $employee_for_task_id, 'next_record' => $employee_for_task_max_record + 1 ];
                }
            }else{
                $next_record = [ 'employee_id' => $employee->first()->id, 'next_record' => 1];
            }

            return $next_record;
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
