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
Route::get('/','HomeController@getLogin');
Route::get('information',function(){
    if( !Session::has('entity') ){
        return Redirect::to('admin');
    }

    return View::make('information');
});

Route::controller('home','HomeController');
Route::controller('student','StudentController');
Route::controller('classroom','ClassroomController');
Route::controller('periode','PeriodeController');
Route::controller('payment','PaymentController');
Route::controller('admin','AdminController');
Route::controller('produit','ProduitController');
Route::controller('client','ClientController');
Route::controller('user','UserController');
Route::controller('vente','VenteController');

Route::get('bender_test',function(){
    $date1 = strtotime('01/01/1999');
    $date2 = strtotime('12/31/1999');
    echo (abs($date1-$date2))/86400;
});


