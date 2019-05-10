<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Absence;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    
    public function employee()
    {
        $employees = Absence::where('start_date_time','not like', '2019-05-26%')->get();
        //$employees = Carbon::today()-Carbon::yesterday();
        $employees =  Absence::all()->where('start_date_time','like','2019-05-26 00:00:00')[0]->start_date_time; //eloquent
        $employees = new Carbon($employees);
        //Absence::where('start_date_time','not like', '2019-05-26%')->get(); //direct request
        
        /* 
        $employees = DB::table('employees')->where('rank_id', '=',1)->get();/* 

        $ultimosProductos = Employee::all()->sortByDesc('created_at')->take(5);
        $productosCategoria = Product::where('category_id', rand(1, 6))->where('active', 1)->take(5)->get();
        $categorias = Category::all(); 
        return view('home', array('ultimosProductos' => $ultimosProductos, 'productosCategoria' => $productosCategoria, 'categorias' => $categorias));
        */
        return (array('employees' => $employees));
        return view('employee', array('employees' => $employees));
    }
/*     public function busqueda(Request $request)
    {
        $arrayProductos = Product::where('object', 'like', '%'.$request->busqueda.'%')
                                ->orWhere('name', 'like', '%'.$request->busqueda.'%')
                                ->orWhere('brand', 'like', '%'.$request->busqueda.'%')
                                ->orWhere('price', $request->busqueda)
                                ->orWhere('model', 'like', '%'.$request->busqueda.'%')
                                ->get();
        return view('search', array('arrayProductos' => $arrayProductos));
        //$employees = Employee::all()->where('id','like',$employee_ids[0]);
    } */
}
