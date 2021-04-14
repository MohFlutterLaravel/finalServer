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





/*
/-------------------------------------------------------------------------
/ Flutter application Routes
/-------------------------------------------------------------------------
*/
Route::post('login', 'ClientController@login');
Route::post('register', 'ClientController@register');
Route::get('categories', 'CategorieController@indexApi');


Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ClientController@logout');
    Route::post('client', 'ClientController@getclient');
    /* location Routes */
    Route::get('locations', 'LocationController@index');
    Route::post('locations/store', 'LocationController@store');
    Route::post('locations/update', 'LocationController@update');
    Route::post('locations/delete', 'LocationController@destroy');

    Route::post('client/test', 'LocationController@test');
    /* Orders Api Routes */
    Route::post('orders', 'OrderapiController@requestOrdersProvider');
});
/*
/-------------------------------------------------------------------------
*/
