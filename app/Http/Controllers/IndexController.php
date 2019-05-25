<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeTask;
use App\Task;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Absence;

use Carbon\Carbon;

class IndexController extends Controller
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
        
        /* if(auth()->guest()) */
        
        $tasks = DB::table('employee_tasks')->where('employee_id',auth()->id())->get();
        
        //dump('tasks');
        //dump($tasks->isEmpty());exit();
        $data = null;
        if($tasks->isEmpty())
        {
            $data[] = [
                'employee' =>   Employee::  findOrFail    (auth()->id())->name.' '.Employee::  findOrFail    (auth()->id())->surname,
                'position' =>   Employee::  findOrFail    (auth()->id())->position->name
            ];
           // dump('is null');
            //dump($data);exit();
            session()->flash('alert-warning', 'El usuario no tiene tareas asignadas');
            //return view('index', ['tasks' => $data]);

        }else{
            foreach ($tasks as $task) {
                
                $data[] = [
                    'id' => $task->id, 
                    'employee' =>   Employee::  findOrFail    ($task->employee_id)->name.' '.Employee::  findOrFail    ($task->employee_id)->surname,
                    'task' =>       Task::      findOrFail    ($task->task_id)->name,
                    'position' =>   Position::  findOrFail    ($task->position_id)->name,
                    'date' => $task->date_time
                ];
            };
           
        }

        return view('index', ['tasks' => $data]);

      
        
        
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
