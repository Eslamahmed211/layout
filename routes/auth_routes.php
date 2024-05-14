<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;


Route::get('login',function (){

return view('auth/login');


})->name("login");

Route::post('login', [authController::class ,"login"])->name("login");

Route::get('logout', [authController::class, "logout"]);

