<?php

use App\Http\Controllers\contactController;
use Illuminate\Support\Facades\Route;

Route::get('home', function () {
    return view('users.home');
});


Route::prefix("groups")->group(function () {
    Route::get('/', [contactController::class, 'index']);
    Route::get('create', [contactController::class, 'create']);
    Route::post('/', [contactController::class, 'store']);
    Route::put('/', [contactController::class, 'update']);
    Route::DELETE('destroy', [contactController::class, 'destroy']);
    Route::get('{group}/contacts', [contactController::class, 'contacts_index']);
    Route::post('{group}/upload_contacts_file', [contactController::class, 'upload_contacts_file']);
    Route::get('{group}/export', [contactController::class, 'export']);

});

Route::prefix("contacts")->group(function () {
    Route::post('/', [contactController::class, 'store_contact']);
    Route::put('/', [contactController::class, 'update_contact']);
    Route::DELETE('destroy', [contactController::class, 'destroy_contact']);
    Route::get('changeOrder', [contactController::class, 'changeOrder']);

});
