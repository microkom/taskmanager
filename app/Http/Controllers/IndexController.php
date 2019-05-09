<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absence;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
    {   
        $employees = Absence::where('start_date_time','not like', '2019-05-26%')->get();
        //$employees = Carbon::today()-Carbon::yesterday();
        $employees =  Absence::all()->where('start_date_time','like','2019-05-26 00:00:00'); //eloquent
        //$employees = new Carbon($employees);
        
        return view('index', array('employees' => $employees));
    }
}
