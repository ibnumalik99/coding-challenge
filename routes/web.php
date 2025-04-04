<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login.index');
});

Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['guest'])->group(function() {
    // Login
    Route::prefix('login')->name('login.')->group(function() {
        Route::get('/', [AuthController::class, 'index'])->name('index');
        Route::post('/', [AuthController::class, 'store'])->name('store');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('task')->name('task.')->group(function() {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/{id}', [TaskController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('delete');
    });

    Route::get('get-employees', [DashboardController::class, 'getEmployees']);
});

// Route::get('/', [AuthController::class, 'index']);
// Route::post('login', [AuthController::class, 'login']);
