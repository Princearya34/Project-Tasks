<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Models\Project;

// Home route
Route::get('/', function () {
    $projects = Project::select('id', 'name', 'description')->get();
    return view('welcome', compact('projects'));
});

// Hello route
Route::get('/hello', [HelloController::class, 'index']);

// User routes
Route::resource('users', UserController::class);
Route::post('/users/{user}/assign-project', [UserController::class, 'assignProject'])->name('users.assignProject');

// Project routes
Route::resource('projects', ProjectController::class);
Route::post('/projects/{project}/assign-user', [ProjectController::class, 'assignUser'])->name('projects.assignUser');

// Task routes (Manually defining instead of `shallow()`)
Route::get('projects/{project}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
Route::get('projects/{project}/tasks/create', [TaskController::class, 'create'])->name('projects.tasks.create');
Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
Route::get('projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
Route::put('projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('projects.tasks.update');
Route::delete('projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

