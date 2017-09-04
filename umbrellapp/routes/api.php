<?php

use Illuminate\Http\Request;

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

/* Users */

Route::get('users', 'UsersController@index');
Route::get('users/{id}', 'UsersController@show');
Route::get('users/name/{name}/email/{email}','UsersController@show_by_name_email');
Route::post('users', 'UsersController@store');
Route::put('users/{id}', 'UsersController@update');
Route::delete('users/{id}', 'UsersController@delete');
Route::delete('users/name/{name}/email/{email}','UsersController@delete_by_name_email');

/* Cities */

Route::get('cities/exists/city/{city}/country/{country}', 'CitiesController@exists');
Route::post('cities', 'CitiesController@addCity');
Route::delete('cities/city/{city}/country/{country}', 'CitiesController@deleteCity');

/* Favorites */

Route::get('favorites/{id}', 'FavoritesController@UsersFavorites');
Route::post('favorites', 'FavoritesController@AddToFavorites');
Route::delete('favorites/{id}', 'FavoritesController@deleteUserFavorites');
Route::delete('favorites/{id}/city/{city}/country/{country}', 'FavoritesController@deleteFavorite');

/* Forecasts */

Route::get('forecasts', 'ForecastsController@getAllForecasts');
Route::get('forecasts/city/{city}/country/{country}', 'ForecastsController@cityForecast');
Route::get('forecasts/city/{city}/country/{country}/date/{date}', 'ForecastsController@dateCity');
Route::post('forecasts', 'ForecastsController@addForecast');
Route::put('forecasts/city/{city}/country/{country}/date/{date}/time/{time}', 'ForecastsController@updateForecast');
Route::delete('forecasts/city/{city}/country/{country}/date/{date}/time/{time}', 'ForecastsController@deleteForecast');

