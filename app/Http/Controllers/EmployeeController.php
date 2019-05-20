<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Position;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $employees = DB::table('employees')->get();
        foreach ($employees as  $employee) {
            
            $employee->position_name = Position::find($employee->position_id)->name;
            $empl[] = $employee;
        }
        return view('employee.index', ['employees' => $empl]);
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $dni = Employee::where('dni', $request->dni)->count();
        $email = Employee::where('email', $request->email)->count();
        $cip_code =Employee::where('cip_code', $request->cip_code)->count();

        if($dni > 0 ){
            $request->session()->flash('alert-danger', 'El DNI ya existe');
            return view('employee.create',['positions' => DB::table('positions')->get()] );
            
        }elseif( $email > 0 ){
            $request->session()->flash('alert-danger', 'Email ya existe!');
            return view('employee.create', ['positions' => DB::table('positions')->get()]);
        }elseif( $cip_code > 0 ){
            $request->session()->flash('alert-danger', 'Código CIP ya existe!');
            return view('employee.create', ['positions' => DB::table('positions')->get()]);
        }else{
            
            $employee = new Employee;
            $employee->position_id = $request->position;
            $employee->scale_number = $request->scale_number;
            $employee->name = $request->name;
            $employee->surname = $request->surname;
            $employee->dni = $request->dni;
            $employee->cip_code = $request->cip_code;
            $employee->email = $request->email;
            
            $employee->save();
            $employee->position_name = Position::find($request->position)->name;
            
            $request->session()->flash('alert-success', 'User was successful added!');
            return view('employee.show', ['employee' => Employee::find($employee->id)]);
        }
        
        
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        return view('employee.show', ['employee' => Employee::find($id)]);
        
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
