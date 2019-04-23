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
    Route::group(['prefix' => 'clients'], function () {
        Route::get('all', 'ClientController@all');
        Route::get('single/{id}', 'ClientController@single');
        Route::post('store', 'ClientController@store');
        Route::patch('update/{id}', 'ClientController@update');
        Route::delete('destroy/{id}', 'ClientController@destroy');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('all', 'OrderController@all');
        Route::get('single/{id}', 'OrderController@single');
        Route::post('store', 'OrderController@store');
        Route::patch('update/{id}', 'OrderController@update');
        Route::delete('destroy/{id}', 'OrderController@destroy');
    });

    Route::group(['prefix' => 'glass-panes'], function () {
        Route::get('all', 'GlassPaneController@all');
        Route::get('single/{id}', 'GlassPaneController@single');
        Route::post('store', 'GlassPaneController@store');
        Route::patch('update/{id}', 'GlassPaneController@update');
        Route::delete('destroy/{id}', 'GlassPaneController@destroy');
    });

    Route::group(['prefix' => 'glass-models'], function () {
        Route::get('all', 'GlassModelController@all');
        Route::get('single/{id}', 'GlassModelController@single');
        Route::post('store', 'GlassModelController@store');
        Route::patch('update/{id}', 'GlassModelController@update');
        Route::delete('destroy/{id}', 'GlassModelController@destroy');
    });

    Route::group(['prefix' => 'cut-models'], function () {
        Route::get('all', 'CutModelController@all');
        Route::get('single/{id}', 'CutModelController@single');
        Route::post('store', 'CutModelController@store');
        Route::patch('update/{id}', 'CutModelController@update');
        Route::delete('destroy/{id}', 'CutModelController@destroy');
    });

    Route::group(['prefix' => 'material'], function () {
        Route::get('all', 'MaterialController@all');
        Route::post('store', 'MaterialController@store');
        Route::patch('update/{id}', 'MaterialController@update');
        Route::delete('destroy/{id}', 'MaterialController@destroy');
    });

    Route::group(['prefix' => 'material-types'], function () {
        Route::get('all', 'MaterialTypeController@all');
        Route::post('store', 'MaterialTypeController@store');
        Route::patch('update/{id}', 'MaterialTypeController@update');
        Route::delete('destroy/{id}', 'MaterialTypeController@destroy');
    });

});


