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
Route::get('/', 'indexController@index');

/**
 * Route to assign tasks
 * This route is used by jquery in the file jquery_functions. BEWARE if it is changed, buttons classes would stop working.
 */

Route::get('/assigntask', 'TaskController@landing');                //landing page

Route::post( '/assigntask', 'TaskController@addtask');              //task adding

/**
 * Route to get a list of all the positions in the database to be loaded when choosing a task.
 */

Route::post('/positions_ajax', 'TaskController@positions_ajax');                    //Internal, ajax url


/**
 * Route to personnel 
 */

Route::get('/employee', 'EmployeeController@list_personnel');


/*
Route::get('/', function () {
    return view('welcome');
}); */
Route::get('/calendar', function () {
    return view('calendar');
});
Route::get('/turn', 'indexController@topTurnPerTaskAndRank');

Route::get('/employees', 'EmployeeController@employee');

//Route::post('/show_today_tasks_ajax', 'TaskController@show_today_tasks_ajax');      //Internal, ajax url

/* Route::get('/assigntask', function(){
    return view('assignTask');
});
 */


 Route::get('/present', 'AddTaskController@whoIsPresent');

 

/* Route::get('/assigntask/error', function(){
    return redirect('assigntask')->with('error', 'There are no employees available on that date');
}); */
