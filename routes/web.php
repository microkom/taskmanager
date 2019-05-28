<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
* Initial landing page.
*/
Route::get('/', 'HomeController@index');

/**
* Route to assign tasks
* This route is used by jquery in the file jquery_functions. BEWARE if it is changed, buttons classes would stop working.
*/





Route::group(['middleware' => ['auth']], function(){
    
    Route::get('/tasks', 'TaskController@landing');                //landing page
    
    Route::group(['middleware' => ['admin']], function(){
        
        Route::get('/absences', 'AbsenceController@index')->name('absences-index'); 
        Route::post('/absences/search', 'AbsenceController@index');
        Route::post('/absences/store', 'AbsenceController@store');
        Route::get('/absences/delete/{id}', 'AbsenceController@destroy');
        Route::get('/absences/create', function(){
            return view ('absence.create', [
                'users' => DB::table('employees')->get()->sortBy('surname'), 
                'notes' => App\Absence::all()->pluck('note')->unique()
                ]);
        }); 
        Route::get('/absences/show/{id}', 'AbsenceController@show');
        
        
        Route::get('/settings/taskposition' , 'TaskController@index');
        
        
        Route::get('/settings/position' , 'PositionController@index');
        
        Route::patch('/position/update/{id}','PositionController@update');
        Route::delete('/position/delete/{id}','PositionController@destroy');
        Route::post('/position/create','PositionController@create');
        
        Route::post('/positions_ajax', 'TaskController@positions_ajax');                    //Internal, ajax url
        
        Route::get('/settings/task', 'TaskController@index');
        Route::patch('/task/update/{id}','TaskController@update');
        Route::delete('/task/delete/{id}','TaskController@destroy');
        Route::post('/task/create','TaskController@create');
        Route::post( '/assigntask', 'TaskController@addtask');              //task adding
        Route::get( '/assigntask', 'TaskController@landing');   
        
        
        
        /**
        * Route to get a list of all the positions in the database to be loaded when choosing a task.
        */
        
        Route::post('/task_positions_ajax', 'TaskController@task_positions_ajax');                    //Internal, ajax url
        
        Route::get('/employee', 'EmployeeController@index')->name('employee.index');
        
        /**
        * Route to personnel adding
        */
        
        Route::get('/employee/create', function(){
            return view('employee.create',  ['positions' => DB::table('positions')->get()]);
        });
        
        Route::post('/employee/store', 'EmployeeController@store')->name('addemployee.store');
        
        /**
        * Route to personnel editing
        */
        Route::get('/employee/edit/{id}', 'EmployeeController@edit'); 
        
        Route::get('/employee/edit', function(){
            return view('editemployee',  ['positions' => DB::table('positions')->get()]);
        });
        
        Route::get('/employee/{id}', 'EmployeeController@show'); 

        /**
         * Promote employee
         * @param id
         */
        Route::patch('/employee/promote/{id}', 'EmployeeController@promote'); 

        Route::patch('/employee/update/{id}', 'EmployeeController@update')->name('employee.update.show'); 
        
        Route::get('/settings', function(){
            return view('settings');
        });
        
    });
});


/*
Route::get('/', function () {
    return view('welcome');
}); */
Route::get('/calendar', function () {
    return view('calendar');
});
Route::get('/turn', 'indexController@topTurnPerTaskAndRank');

Route::get('/employees', 'EmployeeController@employee');

Route::get('/present', 'AddTaskController@whoIsPresent');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
