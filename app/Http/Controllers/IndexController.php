<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absence;
use App\Employee;
use App\Turn;

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
        $absentees = Absence::where('start_date_time','like', $year.'%')->get();    
        
        //get all employees that will be absent on $date given
        $absentees = $this->absences($date);
        
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
    protected function absences($date)
    {   
        $carbonDate = new Carbon($date);  //convert received date to Carbon format
        
        return Absence::where('start_date_time', '<=',$carbonDate)->where('end_date_time', '>=', $carbonDate)->get();    
    }
    
    public function topTurnPerTaskAndRank($task_id=0, $rank_id=0)
    {
        $rank_id = 1;   //simulated rank_id received by parameter
        $task_id = 1;   //simulated task_id received by parameter
        $min_turn = Turn::all()->where('task_id', $task_id)->min('turn'); //get lowest turn done
        $max_turn = Turn::all()->where('task_id', $task_id)->max('turn'); //get highest turn done
        
        $turns = Turn::where('task_id', $task_id)->where('turn', '<=', $min_turn)->get();
        
        //return $turns; //12 20 30
        foreach ($turns as  $value) {
            $employee[] = Employee::find($value->employee_id)->where('rank_id', '=', $rank_id) ;
        }
        return $employee;
        $employee = $this->sortMultidimensionalArray($employee, 'scale_number');
        $employee = collect($employee);
        //$employee = $employee->take(1);
        return /* $min_turn, $max_turn,  */$employee;
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
