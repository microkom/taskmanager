<?php

namespace App\Http\Controllers;
use App\Employee;
use App\EmployeeTask;
use App\Task;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        
        $tasks = DB::table('employee_tasks')->where('employee_id',auth()->id())->get();
        
        
        
        foreach ($tasks as $task) {
            
            $data[] = [
                'id' => $task->id, 
                'employee' =>   Employee::  findOrFail    ($task->employee_id)->name.' '.Employee::  findOrFail    ($task->employee_id)->surname,
                'task' =>       Task::      findOrFail    ($task->task_id)->name,
                'position' =>   Position::  findOrFail    ($task->position_id)->name,
                'date' => $task->date_time];
            };
            
            if(!isset($data)){ 
                
                $data[] = [
                    'employee' =>   Employee::  findOrFail    (auth()->id())->name.' '.Employee::  findOrFail    (auth()->id())->surname,
                    'position' =>   Employee::  findOrFail    (auth()->id())->position->name
                ];
                
                session()->flash('alert-warning', 'El usuario no tiene tareas asignadas');
                return view('index', ['tasks' => $data]);
            }
            
            
            return view('index', ['tasks' => $data]);
        }
    }
    