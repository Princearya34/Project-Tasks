<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Hello route
Route::get('/hello', [HelloController::class, 'index']);

// User routes
Route::resource('users', UserController::class);

// Task routes
Route::resource('tasks', TaskController::class);
