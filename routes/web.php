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
* This route is used by jquery in the file jquery_functions.
* BEWARE if it is changed, buttons classes would stop working.
*/





Route::group(['middleware' => ['auth']], function(){

    Route::get('/tasks', 'TaskController@landing');                //landing page

    Route::group(['middleware' => ['admin']], function(){

        Route::get( '/absences',                'AbsenceController@index')      ->name('absences-index');
        Route::post('/absences/search',         'AbsenceController@search');
        Route::post('/absences/store',          'AbsenceController@store');
        Route::get( '/absences/delete/{id}',    'AbsenceController@destroy')    ->name('absence.destroy');

        Route::get( '/absences/create', function(){
            return view ('absence.create', [
                'employees' => DB::table('employees')->get()->sortBy('surname'),
                'notes' => App\Absence::all()->pluck('note')->unique()
                ]);
            });
            Route::get('/absences/show/{id}', 'AbsenceController@show');


            /** Settings */
            //Route::get('/settings',                 function(){                             return view('settings');});
            Route::get('/settings/position' ,       'PositionController@index');
            Route::get('/settings/taskposition' ,   'TaskController@index_task_position')->name('settings');
            Route::post('/taskposition/create' ,   'TaskController@create_task_position');
            Route::delete('/taskposition/delete/{id}' ,   'TaskController@destroy_task_position');

            Route::get('/settings/task',            'TaskController@index_task');

            /* Position */
            Route::patch('/position/update/{id}','PositionController@update');
            Route::delete('/position/delete/{id}','PositionController@destroy');
            Route::post('/position/create','PositionController@create');
            Route::post('/positions_ajax', 'TaskController@positions_ajax');                    //Internal, ajax url

            /** Task */
            Route::patch('/task/update/{id}','TaskController@update');
            Route::delete('/task/delete/{id}','TaskController@destroy');
            Route::post('/task/create','TaskController@create');

            /** Task assignment */
            Route::post( '/assigntask', 'TaskController@addtask');              //task adding
            Route::get( '/assigntask', 'TaskController@landing');
            Route::get( '/assignTask/delete/{id}', 'TaskController@delete_assigned_task');
            Route::get( '/assignTask/show/{id}', 'TaskController@show_user_tasks');



            /** Route to get a list of all the positions in the database to be loaded when choosing a task. */

            Route::post('/task_positions_ajax', 'TaskController@task_positions_ajax');                    //Internal, ajax url


            /**  Employee  */
            Route::get('/employee', 'EmployeeController@index')->name('employee.index');
            Route::get('/employee/create', function(){
                return view('employee.create',  ['positions' => DB::table('positions')->get(), 'roles' => DB::table('roles')->get()]);
            });


            Route::get('/employee/inactive', function(){
                $employees = DB::table('employees')->where('active',0)->get();
                foreach($employees as $employee){
                    $employee->position_name = App\Position::find($employee->position_id)->name;

                }
                return view('employee.inactive',['employees'=> $employees]);
            });
            Route::get('/employee/{id}', 'EmployeeController@show')->name('employee.show');
            Route::get('/employee/edit/{id}', 'EmployeeController@edit');
            Route::post('/employee/store', 'EmployeeController@store')->name('addemployee.store');
         /*    Route::get('/employee/edit', function(){
                return view('editemployee',  ['positions' => DB::table('positions')->get()]);
            }); */


            /** Promote employee */
            Route::patch('/employee/promote/{id}', 'EmployeeController@promote')->name('employee.promote');
            Route::patch('/employee/update/{id}', 'EmployeeController@update')->name('employee.update.show');
            Route::patch('/employee/active/{id}', 'EmployeeController@active')->name('employee.active.show');

        });
    });

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
