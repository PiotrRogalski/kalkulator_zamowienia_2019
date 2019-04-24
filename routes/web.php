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

Route::get('/', function () {return view('home');});
Route::get('/new-task', function () {return view('newTask');});
Route::get('/show-task/{id}', function () {return view('showTask');});
Route::get('/all-tasks', function () {return view('allTasks');});
Route::get('/settings', function () {return view('settings');});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
