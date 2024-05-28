<?php

use App\Http\Controllers\admin\rolesController;
use App\Http\Controllers\admin\userController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\settingsController;


Route::get('home', function () {
    return view('admin.home');
});

Route::prefix("roles")->middleware("checkRole:roles")->group(function () {
    Route::get('/', [rolesController::class, "index"]);
    Route::get('create', [rolesController::class, "create"]);
    Route::post('/', [rolesController::class, "store"]);
    Route::delete('destroy', [rolesController::class, "destroy"]);
    Route::get('{role}/edit', [rolesController::class, "edit"]);
    Route::put('{role}', [rolesController::class, "update"]);
});

Route::prefix("users")->group(function () {

    Route::middleware('checkRole:users_show')->group(function () {
        Route::get('/', [userController::class, 'index']);
        Route::get('search', [userController::class, 'search']);
    });

    Route::middleware('checkRole:users_action')->group(function () {
        Route::post('/', [userController::class, 'store']);
        Route::get('{user}/edit', [userController::class, 'edit']);
        Route::put('{user}', [userController::class, 'update']);
        Route::DELETE('destroy', [userController::class, 'destroy']);
        Route::get('restore/{id}', [userController::class, 'restore']);
    });
});

Route::prefix("settings")->middleware('checkRole:settings')->group(function () {
    Route::get('/', [settingsController::class, 'index']);
    Route::put('/', [settingsController::class, 'update']);

});


