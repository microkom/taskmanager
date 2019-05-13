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
/*
Route::get('/', function () {
    return view('welcome');
}); */
Route::get('/calendar', function () {
    return view('calendar');
});
Route::get('/turn', 'indexController@topTurnPerTaskAndRank');

Route::get('/employees', 'EmployeeController@employee');

Route::get('/', 'indexController@index');

Route::get('/assigntask', 'TaskController@landing');                //landing page
Route::post( '/addtask', 'TaskController@addtask');

Route::post('/positions_ajax', 'TaskController@positions_ajax');    //Internal url

/* Route::get('/assigntask', function(){
    return view('assignTask');
});
 */

 Route::get('/present', 'AddTaskController@whoIsPresent');
