<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\EmployeeTask;
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
        $employees = DB::table('employees')->where('active',1)->get();
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
        /** Save to session the info of the form in case there is a mistake */
        session()->put('employee.create.position_id', $request->position_id);
        session()->put('employee.create.scale_number', $request->scale_number);
        session()->put('employee.create.name', $request->name);
        session()->put('employee.create.surname', $request->surname);
        session()->put('employee.create.dni', strtoupper($request->dni));
        session()->put('employee.create.cip_code', $request->cip_code);
        session()->put('employee.create.email', $request->email);
        
        
        /* Check the database for duplicates */
        $request->flash();
        $dni = Employee::where('dni', $request->dni)->count();
        $email = User::where('email', $request->email)->count();
        $cip_code =Employee::where('cip_code', $request->cip_code)->count();
        $position_id =Employee::where('position_id', $request->position_id)->get();
        
        if($dni > 0 ){
            $request->session()->flash('alert-danger', 'El DNI ya existe');
            return view('employee.create',['positions' => DB::table('positions')->get(), 'roles'=> DB::table('roles')->get()] );
            
        }elseif( $email > 0 ){
            $request->session()->flash('alert-danger', 'Email ya existe!');
            return view('employee.create', ['positions' => DB::table('positions')->get(),'roles'=> DB::table('roles')->get()] );
        }elseif( $cip_code > 0 ){
            $request->session()->flash('alert-danger', 'Código CIP ya existe!');
            return view('employee.create', ['positions' => DB::table('positions')->get(),'roles'=> DB::table('roles')->get()] );
            
            /// End of checkup
        }else{
            
            /* check for exploits */
            $position_id = $this->test_input($request->position_id);
            $scale_number = $this->test_input($request->scale_number);
            $name = $this->test_input($request->name);
            $surname = $this->test_input($request->surname);
            $dni = $this->test_input($request->dni);
            
            $cip_code = $this->test_input($request->cip_code);
            $surname = $this->test_input($request->surname);
            $email = $this->test_input($request->email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $request->session()->flash('alert-danger', 'Formato de email incorrecto');
                return view('employee.create', ['positions' => DB::table('positions')->get(),'roles'=> DB::table('roles')->get()] );
            }
            if($this->checkdni($dni)){
                $request->session()->flash('alert-danger', 'DNI no válido');
                return view('employee.create', ['positions' => DB::table('positions')->get(),'roles'=> DB::table('roles')->get()] );
            }
            
            
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
            
            /* Wipe the contents for the form because it has been saved */
            session()->forget('employee.create.position_id');
            session()->forget('employee.create.scale_number');
            session()->forget('employee.create.name');
            session()->forget('employee.create.surname');
            session()->forget('employee.create.dni');
            session()->forget('employee.create.cip_code');
            session()->forget('employee.create.email');
            
            session()->flash('alert-success', 'Usuario agregado!');
            return redirect()->route('employee.show', ['id' => $employee]);
        }
        
        
    }
    public function checkdni($dni){
        return (substr('TRWAGMYFPDXBNJZSQVHLCKE', (int)substr($dni, 0, -1)%23, 1) == strtoupper(substr($dni, -1)) )? true: false;
    }
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
        //$employee->position_name = Position::find($employee->position_id)->name;
        
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
        $employee = DB::table('employees')->where('id',$id)->get();
        
        $dni = Employee::where('dni', $request->dni)->count();
        $email = User::where('email', $request->email)->count();
        $scale_number = Employee::where('scale_number', $request->scale_number)->count();
        $cip_code =Employee::where('cip_code', $request->cip_code)->count();
        $position_id =Employee::where('position_id', $request->position_id)->get();
        
        if($dni > 1 ){
            $request->session()->flash('alert-danger', 'El DNI existe en otro registro');
            return view('employee.show',['employee' => $employee] );
        }
        if( $email > 1 ){
            $request->session()->flash('alert-danger', 'Email existe en otro registro!');
            return view('employee.show', ['employee' => $employee]);
        }
        if( $scale_number > 1 ){
            $request->session()->flash('alert-danger', 'Nº Escalafón existe en otro registro');
            return view('employee.show', ['employee' => $employee]);
        }
        if( $cip_code > 1 ){
            $request->session()->flash('alert-danger', 'Código CIP existe en otro registro!');
            return view('employee.show', ['employee' => $employee]);
        }
        
        /* check for exploits */
        $position_id = $this->test_input($request->position_id);
        $scale_number = $this->test_input($request->scale_number);
        $name = $this->test_input($request->name);
        $surname = $this->test_input($request->surname);
        $dni = $this->test_input($request->dni);
        
        $cip_code = $this->test_input($request->cip_code);
        $surname = $this->test_input($request->surname);
        $email = $this->test_input($request->email);
        /* 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $request->session()->flash('alert-danger', 'Formato de email incorrecto');
            return view('employee.show', ['employee' => $employee] );
        }
        dd($employee);  */
        /* if(!$this->checkdni($dni)){
            session()->flash('alert-danger', 'DNI no válido');
            return view('employee.show', ['employee' => $employee] );
        } */
        
        
        $employee = Employee::find($id);
        $employee->update($request->only(['scale_number','name', 'surname', 'dni', 'cip_code']));
        
        $user = User::find($id);
        $user->update($request->only([ 'name','email']));
        
        
        session()->flash('alert-success', 'Se han actualizado los datos');
        return redirect()->route('employee.show', ['employee' => $employee]);
        
    }
    
    public function active($id)
    {
        
        $employee = Employee::find($id);
        
        $employee->update([
            'active' => request()->has('active')
            ]);
            
            
            /* Reprogram all assigned tasks after new absence created */
            
            /* Error control: there are no occurances of the user in the 'employee_tasks' table */
            if( EmployeeTask::where('employee_id', $id)->get()->isEmpty()) return redirect()->route('employee.show', [ $employee]);;
            
            /* Employee's first instance */
            $first_occurance_id = EmployeeTask::where('employee_id', $id)->first()->id;
            
            /* Get all the tasks assigned during and after the date the user is absent*/
            $arr_employee_tasks = EmployeeTask::where('id', '>=', $first_occurance_id)->get()->sortBy('date_time');
            
            /** Delete from the database the previously saved tasks  */
            EmployeeTask::where('id', '>=', $first_occurance_id)->delete();
            
            
            foreach ($arr_employee_tasks as  $emp_task) {
                
                session()->put('task_exit', true);
                
                $a = new TaskController;
                $request = new Request;
                
                $request->date =  $emp_task->date_time ;
                $request->task =  $emp_task->task_id ;
                $request->quantity = 1;
                $request->position = $emp_task->position_id ;
                $a->addTask($request);
                
            }
            
            session()->forget('task_exit');
            
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
    