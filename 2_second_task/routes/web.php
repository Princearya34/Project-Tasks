<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Public Home Route (Redirects to login)
Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Registration Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Dashboard Redirection (Based on Role)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return auth()->user()->hasRole('admin')
        ? redirect()->route('admin.dashboard')
        : redirect()->route('users.profile');
})->name('dashboard');

// Normal User Profile (Assigned Projects & Tasks)
Route::middleware(['auth', 'verified'])->get('/profile/view', [UserController::class, 'profile'])->name('users.profile');

// Profile Management Routes
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Admin Panel Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // ✅ User Management (With Role & Project Assignments)
    Route::middleware(['permission:manage users'])->group(function () {
        Route::resource('users', UserController::class);
        
        Route::prefix('users/{user}')->group(function () {
            Route::delete('/', [UserController::class, 'destroy'])->name('users.destroy');
            Route::post('/assign-project', [UserController::class, 'assignProject'])->name('users.assignProject');
            Route::get('/assign-role', [UserController::class, 'showAssignRole'])->name('users.showAssignRole');
            Route::put('/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
        });
    });

    // ✅ Role Management (Dynamic Role & Permission Assignment)
    Route::middleware(['permission:manage roles'])->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // ✅ Project Management
    Route::middleware(['permission:manage projects'])->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::post('/projects/{project}/assign-user', [ProjectController::class, 'assignUser'])->name('projects.assignUser');
    });

    // ✅ Task Management (Under Projects)
    Route::middleware(['permission:manage tasks'])->group(function () {
        Route::prefix('projects/{project}/tasks')->group(function () {
            Route::get('/', [TaskController::class, 'index'])->name('projects.tasks.index');
            Route::get('/create', [TaskController::class, 'create'])->name('projects.tasks.create');
            Route::post('/', [TaskController::class, 'store'])->name('projects.tasks.store');
            Route::get('/{task}', [TaskController::class, 'show'])->name('projects.tasks.show');
            Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
            Route::put('/{task}', [TaskController::class, 'update'])->name('projects.tasks.update');
            Route::delete('/{task}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');
        });
    });
});

// Authentication Routes (Default Laravel Auth)
require __DIR__.'/auth.php';
