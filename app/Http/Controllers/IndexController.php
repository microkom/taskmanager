<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absence;
use App\Employee;
use App\Turn;
use App\Task;

use Carbon\Carbon;

class IndexController extends Controller
{
    public function index($date=0, $rank=0) //revise
    {   
        $date = '2019-05-28 00:00:00';                           //simulated date received by parameter
        $rank = 1;                                               //simulated rank received by parameter
        $dateOrig = $date;                                       //keep original date
        $year = substr ($date, 0, 4);                            //filter the year 
        $dateShow = substr($date, 0, 10);                        //get only the date 2000-02-02
        $dateShow = new Carbon($dateShow);                       //convert date to Carbon format
        $dateShow = $dateShow->locale('es')->isoFormat('dddd, D MMMM YYYY');        //format date to Spanish locale
        
        //filter absentees per year [attempt to optimize machine processing]
        //$absentees = Absence::where('start_date_time','like', $year.'%')->get();    
        
        //get all employees that will be absent on $date given
        $absentees = $this->whoIsAbsent($date);
        
        //filter employees who WILL BE PRESENT base on the those who will be absent
        foreach ($absentees as $key => $absent) {
            $employee[] = Employee::all()->where('id','<>',($absent->employee_id))->where('rank_id', $rank);   
        }
        //convert the array to collection for easier handling        
        $employee = collect($employee[0]);
        
        //Order by scale_number ascending
        $employee = $employee->sortByDesc('scale_number');
        /*  
        //number of employees in the list
        $employee = $employee->take(3);
        */      
        return view('index', array('employees' => $employee), array('date' => $dateShow));
    }
    
    
    /**
    * select all absentees based on received date
    */

    
    public function topTurnPerTaskAndRank($task_id=0, $rank_id=0)
    {
        $rank_id = 1;   //simulated rank_id received by parameter
        $task_id = 1;   //simulated task_id received by parameter
        
        //check if task exists
        if(!Task::find($task_id)) return [-1, 'No task found'];
        
        //check if the table turns contains any data
        if(Turn::where('task_id', $task_id)->get()->count())
        {
            $min_turn = Turn::all()->where('task_id', $task_id)->min('turn'); //get lowest turn done
            $turns = Turn::where('task_id', $task_id)->where('turn', '<=', $min_turn)->get();
            
            //find info about the employees in the turns table
            foreach ($turns as  $key => $value) {
                //get only ids
                $ids[] = $value->employee_id;
            }
            //return $ids;
//get employees info who are present in the turns table
                $employeeData  = Employee::find($ids)->sortBy('scale_number')->where('rank_id', '=', $rank_id);
                return /* response()->json */$employeeData;
                if(isset($employee))
            {
                $employee = collect($employee);
                
                $employee = $employee->sortBy('scale_number');
                $employee = $employee->values()->all();
                //$employee = $this->sortMultidimensionalArray($employee, 'scale_number');
                return $employee;
                
                //$employee = $employee->take(1);
                return /* $min_turn, $max_turn,  */$employee;
            }else{
                return 0;
            }
            
        }else{
            $min_turn = 0;
            return 0;
        }
    }
    
    /**
    * Sort multidimensional array in ascending order
    */
    public function sortMultidimensionalArray($a, $subkey)
    {
        foreach ($a as $k => $v) {
            $b[$k] = $v[$subkey];
        }
        asort($b);
        foreach ($b as $key => $value) {
            $c[] = $a[$key];
        }
        return $c;
    }
    
    /**
    * Sort multidimensional array in descending order
    */
    public function sortMultidimensionalArrayDesc($a, $subkey)
    {
        foreach ($a as $k => $v) {
            $b[$k] = $v[$subkey];
        }
        arsort($b);
        foreach ($b as $key => $value) {
            $c[] = $a[$key];
        }
        return $c;
    }
    
    
}
