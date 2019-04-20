<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// AUTH endpoints
Route::group([
    'middleware' => 'api',
], function () {
    Route::get('clients', 'ClientController@all');

    Route::group(['prefix' => 'orders'], function () {
        Route::get('all', 'OrderController@all');
        Route::get('single/{id}', 'OrderController@single');
        Route::post('store', 'OrderController@store');
        Route::patch('update', 'OrderController@update');
        Route::delete('destroy/{id}', 'OrderController@destroy');
    });

});

