<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Tickets Routes
    Route::resource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');

    // Comments Routes
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// Home redirect
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('tickets.index');
    }
    return redirect()->route('login');
});
