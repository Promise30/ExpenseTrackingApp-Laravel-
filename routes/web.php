<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Expense related routes
// Route::middleware('auth')->group(function () {
// Route::get('expenses', [ExpenseController::class, 'index'])->name('expense.index');
// Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expense.create');
// Route::post('expenses', [ExpenseController::class, 'store'])->name('expense.store');
// Route::get('expenses/{expense}', [ExpenseController::class, 'show'])->name('expense.show');
// Route::get('expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expense.edit');
// Route::patch('expenses/{expense}', [ExpenseController::class, 'update'])->name('expense.update');
// Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expense.destroy');

// });
// Expense related routes
Route::middleware('auth')->prefix('expenses')->name('expense.')->group(function () {
    Route::controller(ExpenseController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('expenses', 'store')->name('store');
        Route::get('/{expense}', 'show')->name('show');
        Route::get('/{expense}/edit', 'edit')->name('edit');
        Route::patch('/{expense}', 'update')->name('update');
        Route::delete('/{expense}', 'destroy')->name('destroy');
        Route::patch('/{expense}/status/{status}')->name('updateStatus');
    });
});
Route::name('notification.')->group(function () {
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'allNotifications')->name('allNotifications');
        Route::get('/notifications/{id}', 'read')->name('read');
        Route::post('/notifications/readAll', 'markAllAsRead')->name('readAll');
    });
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::controller(SuperAdminController::class)->group(function () {
        Route::get('/', 'index')->name('admin');
        Route::get('/assignNewRole/{user}', 'assignRole')->name('assignRole');
        Route::post('/storeRole', 'storeAssignedRole')->name('storeAssignedRole');
    });
});
require __DIR__.'/auth.php';
