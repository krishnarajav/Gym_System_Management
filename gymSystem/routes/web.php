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
Route::post('/home', [AppManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AppManager::class, 'registration'])->name('registration');
Route::post('/registration', [AppManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AppManager::class, 'logout'])->name('logout');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AppManager::class, 'showLoginForm'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [AppManager::class, 'showHomepage'])->name('homepage');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/plansview', [AppManager::class, 'plansView'])->name('plans');
    Route::get('/plandetailsform', [AppManager::class, 'createPlan'])->name('planform');
    Route::post('/storePlan', [AppManager::class, 'storePlan'])->name('storeplan');
    Route::get('/editplan/{id}', [AppManager::class, 'editPlan'])->name('editplan');
    Route::put('/updateplan/{id}', [AppManager::class, 'updatePlan'])->name('updateplan');
    Route::delete('/deleteplan/{id}', [AppManager::class, 'deletePlan'])->name('deleteplan');

    Route::get('/customersview', [AppManager::class, 'customersView'])->name('customers');
    Route::get('/customerdetailsform', [AppManager::class, 'createCustomer'])->name('customerform');
    Route::post('/storeCustomer', [AppManager::class, 'storeCustomer'])->name('storecustomer');
    Route::get('/editcustomer/{id}', [AppManager::class, 'editCustomer'])->name('editcustomer');
    Route::put('/updatecustomer/{id}', [AppManager::class, 'updateCustomer'])->name('updatecustomer');
    Route::delete('/deletecustomer/{id}', [AppManager::class, 'deleteCustomer'])->name('deletecustomer');

    Route::get('/trainersview', [AppManager::class, 'trainersView'])->name('trainers');
    Route::get('/trainerdetailsform', [AppManager::class, 'createTrainer'])->name('trainerform');
    Route::post('/storeTrainer', [AppManager::class, 'storeTrainer'])->name('storetrainer');

    Route::get('/paytransactionsview', [AppManager::class, 'paytransactionsView'])->name('paytransactions');
    Route::get('/paytransactiondetailsform', [AppManager::class, 'createPayTransaction'])->name('paytransactionform');
    Route::post('/storePayTransaction', [AppManager::class, 'storePayTransaction'])->name('storepaytransaction');

    Route::get('/sessionsview', [AppManager::class, 'sessionsView'])->name('sessions');
    Route::get('/sessiondetailsform', [AppManager::class, 'createSession'])->name('sessionform');
    Route::post('/storeSession', [AppManager::class, 'storeSession'])->name('storesession');

    Route::get('/equipmentsview', [AppManager::class, 'equipmentsView'])->name('equipments');
    Route::get('/equipmentdetailsform', [AppManager::class, 'createEquipment'])->name('equipmentform');
    Route::post('/storeEquipment', [AppManager::class, 'storeEquipment'])->name('storeequipment');
});