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
    public function index($date=0, $position=0) //revise
    {
        $date = '2019-05-28 00:00:00';                           //simulated date received by parameter
        $position = 1;                                               //simulated position received by parameter
        $dateOrig = $date;                                       //keep original date
        $year = substr ($date, 0, 4);                            //filter the year
        $dateShow = substr($date, 0, 10);                        //get only the date 2000-02-02
        $dateShow = new Carbon($dateShow);                       //convert date to Carbon format
        $dateShow = $dateShow->locale('es')->isoFormat('dddd, D MMMM YYYY');        //format date to Spanish locale

/*         //filter absentees per year [attempt to optimize machine processing]
        $absentees = Absence::where('start_date_time','like', $year.'%')->get();

        //get all employees that will be absent on $date given
        $absentees = $this->whoIsAbsent($date);

        //filter employees who WILL BE PRESENT base on the those who will be absent
        foreach ($absentees as $key => $absent) {
            $employee[] = Employee::all()->where('id','<>',($absent->employee_id))->where('position_id', $position);
        }
        //convert the array to collection for easier handling
        if(isset($employee)){
            $employee = collect($employee[0]);
            //Order by scale_number ascending
            $employee = $employee->sortByDesc('scale_number');
        }else{
            $employee[] = Employee::all()->where('position_id', $position);
        } */
        $employee = Employee::all()->where('position_id', $position);
        /*
        //number of employees in the list
        $employee = $employee->take(3);
        */
        return view('index', array('employees' => $employee), array('date' => $dateShow));
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
