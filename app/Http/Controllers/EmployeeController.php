<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Position;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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
        return view('employee.index', ['employees' => $empl, 'roles'=> DB::table('roles')->get()]);
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
        
        session()->put('employee.create.position_id', $request->position_id);
        session()->put('employee.create.scale_number', $request->scale_number);
        session()->put('employee.create.name', $request->name);
        session()->put('employee.create.surname', $request->surname);
        session()->put('employee.create.dni', strtoupper($request->dni));
        session()->put('employee.create.cip_code', $request->cip_code);
        session()->put('employee.create.email', $request->email);
        
        $request->flash();
        $dni = Employee::where('dni', $request->dni)->count();
        $email = User::where('email', $request->email)->count();
        $cip_code =Employee::where('cip_code', $request->cip_code)->count();
        $position_id =Employee::where('position_id', $request->position_id)->get();
        /*      dump('$position_id');
        dump($position_id); */
        
        if($dni > 0 ){
            $request->session()->flash('alert-danger', 'El DNI ya existe');
            return view('employee.create',['positions' => DB::table('positions')->get(), 'roles'=> DB::table('roles')->get()] );
            
        }elseif( $email > 0 ){
            $request->session()->flash('alert-danger', 'Email ya existe!');
            return view('employee.create', ['positions' => DB::table('positions')->get(),'roles'=> DB::table('roles')->get()] );
        }elseif( $cip_code > 0 ){
            $request->session()->flash('alert-danger', 'Código CIP ya existe!');
            return view('employee.create', ['positions' => DB::table('positions')->get(),'roles'=> DB::table('roles')->get()] );
        }/* elseif( $position_id->isEmpty()){
            $request->session()->flash('alert-danger', 'Error de empleo');
            return view('employee.create', ['positions' => DB::table('positions')->get()]);
        } */else{
            
            $employee = new Employee;
            $employee->position_id = $request->position_id;
            $employee->scale_number = $request->scale_number;
            $employee->name = $request->name;
            $employee->surname = $request->surname;
            $employee->dni = strtoupper($request->dni);
            $employee->cip_code = $request->cip_code;
            $employee->save();
            
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->dni);
            $user->employee_id = $employee->id;
            $user->save();
            
            session()->forget('employee.create.position_id');
            session()->forget('employee.create.scale_number');
            session()->forget('employee.create.name');
            session()->forget('employee.create.surname');
            session()->forget('employee.create.dni');
            session()->forget('employee.create.cip_code');
            
            session()->flash('alert-success', 'Usuario agregado!');
            return redirect()->route('employee.show', ['id' => $employee]);
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
        $employee = Employee::find($id);
        $employee->position_name = Position::find($employee->position_id)->name;
        
        return view('employee.show', ['employee' => $employee]);
        
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
        /* $request data received from employee/show */
        //dd($request);
        $dni = Employee::where('dni', $request->dni)->count();
        $email = Employee::where('email', $request->email)->count();
        $scale_number = Employee::where('scale_number', $request->scale_number)->count();
        $cip_code =Employee::where('cip_code', $request->cip_code)->count();
        $position_id =Employee::where('position_id', $request->position_id)->get();
        
        if($dni > 1 ){
            $request->session()->flash('alert-danger', 'El DNI existe en otro registro');
            return view('employee.show',['employee' => $request] );
        }
        if( $email > 1 ){
            $request->session()->flash('alert-danger', 'Email existe en otro registro!');
            return view('employee.show', ['employee' => $request]);
        }
        if( $scale_number > 1 ){
            $request->session()->flash('alert-danger', 'Nº Escalafón existe en otro registro');
            return view('employee.show', ['employee' => $request]);
        }
        if( $cip_code > 1 ){
            $request->session()->flash('alert-danger', 'Código CIP existe en otro registro!');
            return view('employee.show', ['employee' => $request]);
        }
        
        
        
        $employee = Employee::find($id);
        $employee->update($request->only(['scale_number','name', 'surname', 'dni', 'cip_code','email']));
        
        
        
        session()->flash('alert-success', 'Se han actualizado los datos');
        return redirect()->route('employee.show', ['employee' => $employee]);
        
        
    }
    
    public function active($id)
    {
        
        $employee = Employee::find($id);
        
        $employee->update([
            'active' => request()->has('active')
            ]);
            
            session()->flash('alert-success', 'Se han actualizado los datos');
            return redirect()->route('employee.show', [ $employee]);
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
        
        
        /**
        * Show the form for promoting a user.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function promote($id)
        {
            
            $user = Employee::find($id);
            
            if( $user->position_id == Position::all()->max('id') ){
                session()->flash('alert-danger', 'El usuario no puede ascender más.');
                return back();
            }
            
            $user->position_id += 1;
            $user->update(['position_id'=> $user->position_id]);
            session()->flash('alert-success', 'El usuario ha sido ascendido de empleo.');
            /* return redirect()->route('employee.show', ['employee' => $employee]); */
            return redirect()->route('employee.show',  [$user] );
        }
    }
    