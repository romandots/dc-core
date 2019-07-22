<?php
/**
 * File: api.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

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

Route::post('users/from_person', 'UserController@createFromPerson');
Route::patch('users/{id}/password', 'UserController@updatePassword');
Route::resource('users', 'UserController')
    ->only(['show', 'store', 'update', 'destroy']);

Route::resource('people', 'PersonController')
    ->only(['show', 'store', 'update', 'destroy']);

Route::post('students/from_person', 'StudentController@createFromPerson');
Route::resource('students', 'StudentController')
    ->only(['show', 'store', 'update', 'destroy']);

Route::post('instructors/from_person', 'InstructorController@createFromPerson');
Route::resource('instructors', 'InstructorController')
    ->only(['show', 'store', 'update', 'destroy']);

Route::post('customers/from_person', 'CustomerController@createFromPerson');
Route::resource('customers', 'CustomerController')
    ->only(['show', 'store', 'destroy']);

Route::get('contracts/{contract}', 'ContractController@show');
Route::post('contracts/{contract}', 'ContractController@sign');
Route::delete('contracts/{contract}', 'ContractController@terminate');
