<?php

use App\Http\Controllers\Admin\DashbordController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\LoginController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([ 'namespace' => 'admin', 'middleware' =>'auth:admin'],function(){

    Route::get('/',[DashbordController::class, 'index']) -> name('admin.dashboard');
});





Route::group([ 'namespace' => 'admin','middleware' =>'guest:admin'],function(){
   Route::get('login',[LoginController::class,'getLogin'])-> name('get.admin.login');
   Route::post('login',[LoginController::class,'login']) -> name('admin.login');



});
