<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Route;

// Default route
Route::get('/', function () {
    return view('login');
});

// Dashboard route
Route::get('/dashboard', [ItemController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Items routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');

// Contracts routes
Route::get('/items/{item}/borrow', [ContractController::class, 'create'])->name('contracts.create');
Route::post('/items/{item}/borrow', [ContractController::class, 'store'])->name('contracts.store');
Route::post('/contracts/{contract}/accept', [ContractController::class, 'accept'])->name('contracts.accept');
Route::post('/contracts/{contract}/reject', [ContractController::class, 'reject'])->name('contracts.reject');
Route::post('/contracts/{contract}/return', [ContractController::class, 'return'])->name('contracts.return');

// Reviews routes
Route::get('/users/{user}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/users/{user}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/users/{user}/reviews', [ReviewController::class, 'show'])->name('reviews.show');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
