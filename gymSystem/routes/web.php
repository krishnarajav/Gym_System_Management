<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppManager;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Trainer;
use App\Models\Equipment;
use App\Models\Plan;
use App\Models\Sessions;
use App\Models\Pay_Transaction;

Route::get('/', [AppManager::class, 'login'])->name('login');
Route::post('/login', [AppManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AppManager::class, 'registration'])->name('registration');
Route::post('/registration', [AppManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AppManager::class, 'logout'])->name('logout');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('homepage');
    })->name('homepage');
});
