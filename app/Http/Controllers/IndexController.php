<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absence;
use App\Employee;

use Carbon\Carbon;

class IndexController extends Controller
{
    public function index($date=0, $rank=0) //revise
    {   
        $date = '2019-05-28 00:00:00';                                                          //date received by parameter
        $rank = 2;                                                                              //rank received by parameter
        $dateOrig = $date;                                                                      //keep original date
        $year = substr ($date, 0, 4);                                                           //filter the year 
        
        $dateShow = substr($date, 0, 10);
        $dateShow = new Carbon($dateShow);
        $dateShow = $dateShow->locale('es')->isoFormat('dddd, D MMMM YYYY');
        
        $absentees = Absence::where('start_date_time','like', $year.'%')->get();                //filter absentees per year [attempt to optimize machine processing]
        
        $absentees = $this->absences($date);                                                    //get all absentees based on received date

        foreach ($absentees as $key => $absent) {
            $employee[] = Employee::all()->where('id','<>',($absent->employee_id))->where('rank_id', $rank)->sortBy($absent->scale_number);    //filter employees 
        }
        
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
}
