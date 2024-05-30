<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;

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
Route::get('expenses', [ExpenseController::class, 'index'])->name('expense.index');
Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expense.create');
Route::post('expenses', [ExpenseController::class, 'store'])->name('expense.store');
Route::get('expenses/{expense}', [ExpenseController::class, 'show'])->name('expense.show');
Route::get('expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expense.edit');
Route::patch('expenses/{expense}', [ExpenseController::class, 'update'])->name('expense.update');
Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expense.destroy');

require __DIR__.'/auth.php';
