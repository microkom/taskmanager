<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Absence;
use App\Employee;
use Carbon\Carbon;

class AbsenceController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $start_date = new Carbon($request->start_date);
        $end_date = new Carbon($request->end_date);
        
        if($request->start_date != null && $request->end_date != null){
            $absence =  Absence::where('start_date_time','>=',$start_date)->where('end_date_time','<=', $end_date)->get();
            
        }elseif($request->start_date == null && $request->end_date != null){
            $absence =  Absence::where('end_date_time','<=', $end_date)->get();
            
        }elseif($request->start_date != null && $request->end_date == null){
            $absence =  Absence::where('start_date_time','>=',$start_date)->get();
            
        }else{    

            //Check if the end date is after today - This is the index view
            $tdate = new Carbon(date("Y-m-d"));                
            $absence =  DB::table('absences')->where('end_date_time','>=',$tdate)->get();
        }
        
        foreach ($absence as $person) {
            $person->_name = Employee::find($person->employee_id)->name;
            $person->surname = Employee::find($person->employee_id)->surname;
            $person->name = $person->_name." ".$person->surname;
        }
        return view('absence.index', ['absences' => $absence]);
    }
    
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
