<?php 

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Munna\Pm\Http\Controllers'], function(){
    Route::get('my/path', 'PerfectMoneyController@path');
});