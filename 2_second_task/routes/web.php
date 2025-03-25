<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Public Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authenticated Routes (For Verified Users)
Route::middleware(['auth', 'verified'])->group(function () {
    // Normal User & Admin Dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Normal User Profile Route (Shows assigned projects & tasks)
    Route::get('/profile/view', [UserController::class, 'profile'])->name('users.profile');

    // Profile Routes (Edit, Update, Delete)
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Admin-Only Routes (User & Project Management)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard Route
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Ensure this view exists
    })->name('admin.dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::prefix('users/{user}')->group(function () {
        Route::post('/assign-project', [UserController::class, 'assignProject'])->name('users.assignProject');
        Route::get('/assign-role', [UserController::class, 'showAssignRole'])->name('users.showAssignRole');
        Route::put('/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    });

    // Project Management
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/assign-user', [ProjectController::class, 'assignUser'])->name('projects.assignUser');
});

// Task Routes (Accessible to Authenticated Users)
Route::middleware(['auth'])->group(function () {
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

// Authentication Routes
require __DIR__.'/auth.php';
