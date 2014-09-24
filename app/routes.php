<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome' );
Route::get('/{year}', 'HomeController@showWelcome' );
Route::get('/player/{team}/{player}', array( 'as' => 'player', 'uses' => 'PlayerController@showPlayer' ) );
