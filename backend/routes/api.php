<?php

use Illuminate\Http\Request;

Route::post('person', 'PersonController@add')->middleware('cors');
Route::put('person/{person}', 'PersonController@update')->middleware('cors');
Route::delete('person/{person}', 'PersonController@delete')->middleware('cors');
Route::get('person', 'PersonController@person')->middleware('cors');
Route::get('person/{id}', 'PersonController@personById')->middleware('cors');

