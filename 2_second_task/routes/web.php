<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Models\Project;

// ✅ Home Route
Route::get('/', function () {
    $projects = Project::select('id', 'name', 'description')->get();
    return view('welcome', compact('projects'));
});

// ✅ Hello Route
Route::get('/hello', [HelloController::class, 'index']);

// ✅ User Routes
Route::resource('users', UserController::class);
Route::post('/users/{user}/assign-project', [UserController::class, 'assignProject'])
    ->name('users.assignProject');

// ✅ Project Routes
Route::resource('projects', ProjectController::class);
Route::post('/projects/{project}/assign-user', [ProjectController::class, 'assignUser'])
    ->name('projects.assignUser');

// ✅ Task Routes (Scoped to a Project)
Route::prefix('projects/{project}')->group(function () {
    // ✅ Ensure 'create' comes before dynamic '{task}' routes
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('projects.tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');

    Route::get('/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('projects.tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');

    // ✅ Keep 'show' after other task routes
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('projects.tasks.show');

    // ✅ API Endpoint for AJAX Task Fetching
    Route::get('/tasks/api', [TaskController::class, 'fetchTasks'])->name('projects.tasks.api');
});
