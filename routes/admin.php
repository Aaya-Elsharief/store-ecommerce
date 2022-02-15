<?php

use App\Http\Controllers\Admin\DashbordController;
use App\Http\Controllers\Admin\LanguageController;
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
define('PAGINATION_COUNT', 10);

Route::group([ 'namespace' => 'admin', 'middleware' =>'auth:admin'],function(){

    Route::get('/',[DashbordController::class, 'index']) -> name('admin.dashboard');

    ########################## Begin Languages Routes #############################
    Route::group(['prefix' => 'languages'], function(){

        Route::get('/',[LanguageController::class, 'index']) -> name('admin.languages'); //all languages
        Route::get('create',[LanguageController::class, 'create']) -> name('admin.languages.create');
        Route::post('store',[LanguageController::class, 'store']) -> name('admin.languages.store');

        Route::get('edit/{id}',[LanguageController::class, 'edit']) -> name('admin.languages.edit');
        Route::post('update/{id}',[LanguageController::class, 'update']) -> name('admin.languages.update');

        Route::get('delete/{id}',[LanguageController::class, 'destroy']) -> name('admin.languages.delete');


    });


    ########################## End Languages Routes #############################


});





Route::group([ 'namespace' => 'admin','middleware' =>'guest:admin'],function(){
   Route::get('login',[LoginController::class,'getLogin'])-> name('get.admin.login');
   Route::post('login',[LoginController::class,'login']) -> name('admin.login');



});
