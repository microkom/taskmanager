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

        $employee = $this-> whoIsPresent($date, $position_id, $task_id);

        $employee = $this-> orderAccordingToTask(["employee" => $employee, "task" => $task_id]);

        return  $employee;

        $count = EmployeeTask::where('task_id', $task_id)->get();
        return $count;
        $min_record = $this-> lowestRecordedTaskTurn($task_id, $position_id, $employee->first()->id);

        if($min_record>  0){
            $data = new EmployeeTask();
            $data->task_id = $task_id;
            $data->employee_id = $employee->first()->id;
            $data->position_id = $employee->first()->position_id;
            $data->date_time = new Carbon($date);
            $data->record_counter = 1;
            $data->save();

        }else{


            $data = new EmployeeTask();
            $data->task_id = $task_id;
            $data->employee_id = $employee->first()->id;
            $data->position_id = $employee->first()->position_id;
            $data->date_time = new Carbon($date);
            $data->record_counter =  3;//DB::table('employee_tasks')->where('employee_id', $employee->first()->id)->get();
            $data->save();


        }    $task = Task::all();
        return view('assignTask', ['tasks' => $task]);

    }

    /*********************************************************
    * Order collection according to task
    * @param $data array containing the array to be ordered and task
    * @return $employees array ordered
    */
    protected function orderAccordingToTask($data)
    {
        $employee = Employee::find($data['employee']);
    /*     dump('employee');
        dump( $employee);
     */
        switch ( $data['task']) {
            case '1':
            case '2':
            $employees = $employee->sortByDesc('scale_number');
            break;
            default:
            $employees = $employee->sortBy('scale_number');
            break;
        }
        return ($employees);
    }

    /*********************************************************
    *  Lowest record of a task
    * @param $task_id Id of the task
    * @param $position_id Position for that specific task
    * @return $min_turn
    */
    public function lowestRecordedTaskTurn($task_id, $position_id, $employee_id)
    {
        //return $employee_id;
        if(EmployeeTask::where('task_id', $task_id)->where('employee_id', $employee_id)->where('record_counter')->exists()){
            $min_record = EmployeeTask::where('task_id', $task_id)->where('employee_id', $employee_id)->min('record_counter')->get(); //get lowest record done
        }else{
            $min_record = 0;
        }
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
/*         dump('idabsentees');
        dump( $idAbsentees); */
        //get all employees in database filtering $position_id
        $allEmployees = Employee::all()->where('position_id', $position_id);

/*         dump( 'allEmployees');
        dump( $allEmployees); */
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


/*             dump('idEMployees');
            dump($idEMployees);

            dump( 'idAbsent');
            dump( $idAbsent); */

            $id = array_diff($idEMployees, $idAbsent);
/*             dump( 'result');
            dump($result); */

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
        $onduty = EmployeeTask::
        where('date_time', '=', $carbonDate)->
        get();

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
            ->orWhere( 'task_id', '=', 2);
        })
        ->get();

        //extract employee ids
        foreach ( $afterDuty as $itemId) {
            $id[] = $itemId->employee_id;
        }

        //no value to send
        if (!isset($id)){
            return [];
        }else{
            $uniqueIds = array_unique($id);
            $uniqueIds = array_values($uniqueIds);
            return $uniqueIds;
        }


        /**borrar */
        //merging the 2 lists of employees unavailable
        /* $absences = collect( $absences);
        $absences = $absences->merge($onduty);
        $absences = $absences->merge( $afterDuty); */
        ////////////////////////////////////////////////


        //borrar
        /* else if(!isset($absences)){
            return ($absences);
        }else {

            //use id of absentees to get all info of employee
            foreach ($absences as $absence) {
                $employees[] = Employee::findOrFail($absence->employee_id);   //previous merge prevents from using $absence->employee

            }

            //filter by position_id
            foreach ( $employees as $employee) {
                if( $employee->position_id == $position_id){
                    $absentees[] = $employee;

                }
            }
            return $absentees;
        } */

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
