<?php

use App\Http\Controllers\Admin\DashbordController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MainCategoriesController;
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

    Route::get('helper-n',function (){
        return show();
    });
    ########################## Begin Languages Routes #############################
    Route::group(['prefix' => 'languages'], function(){

        Route::get('/',[LanguageController::class, 'index']) -> name('admin.languages'); //all languages
        Route::get('create',[LanguageController::class, 'create']) -> name('admin.languages.create');
        Route::post('store',[LanguageController::class, 'store']) -> name('admin.languages.store');

        Route::get('edit/{id}',[LanguageController::class, 'edit']) -> name('admin.languages.edit');
        Route::post('update/{id}',[LanguageController::class, 'update']) -> name('admin.languages.update');

        Route::get('delete/{id}',[LanguageController::class, 'destroy']) -> name('admin.languages.delete');


    });
    ########################## End  Languages Routes #############################


    ########################## Begin Main Categories  Routes #############################
    Route::group(['prefix' => 'main_categories'], function(){

        Route::get('/',[MainCategoriesController::class, 'index']) -> name('admin.maincategories'); //all languages
        Route::get('create',[MainCategoriesController::class, 'create']) -> name('admin.maincategories.create');
        Route::post('store',[MainCategoriesController::class, 'store']) -> name('admin.maincategories.store');

        Route::get('edit/{id}',[MainCategoriesController::class, 'edit']) -> name('admin.maincategories.edit');
        Route::post('update/{id}',[MainCategoriesController::class, 'update']) -> name('admin.maincategories.update');

        Route::get('delete/{id}',[MainCategoriesController::class, 'destroy']) -> name('admin.maincategories.delete');


    });

    ########################## End Main Categories Routes#############################

});





Route::group([ 'namespace' => 'admin','middleware' =>'guest:admin'],function(){
   Route::get('login',[LoginController::class,'getLogin'])-> name('get.admin.login');
   Route::post('login',[LoginController::class,'login']) -> name('admin.login');



});
