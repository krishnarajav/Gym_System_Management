<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppManager;

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
    Route::get('/edittrainer/{id}', [AppManager::class, 'editTrainer'])->name('edittrainer');
    Route::put('/updatetrainer/{id}', [AppManager::class, 'updateTrainer'])->name('updatetrainer');
    Route::delete('/deletetrainer/{id}', [AppManager::class, 'deleteTrainer'])->name('deletetrainer');

    Route::get('/paytransactionsview', [AppManager::class, 'paytransactionsView'])->name('paytransactions');
    Route::get('/paytransactiondetailsform', [AppManager::class, 'createPayTransaction'])->name('paytransactionform');
    Route::post('/storePayTransaction', [AppManager::class, 'storePayTransaction'])->name('storepaytransaction');
    Route::delete('/deletepaytransaction/{id}', [AppManager::class, 'deletePayTransaction'])->name('deletepaytransaction');

    Route::get('/sessionsview', [AppManager::class, 'sessionsView'])->name('sessions');
    Route::get('/sessiondetailsform', [AppManager::class, 'createSession'])->name('sessionform');
    Route::post('/storeSession', [AppManager::class, 'storeSession'])->name('storesession');
    Route::get('/editsession/{id}', [AppManager::class, 'editSession'])->name('editsession');
    Route::put('/updatesession/{id}', [AppManager::class, 'updateSession'])->name('updatesession');
    Route::delete('/deletesession/{id}', [AppManager::class, 'deleteSession'])->name('deletesession');

    Route::get('/equipmentsview', [AppManager::class, 'equipmentsView'])->name('equipments');
    Route::get('/equipmentdetailsform', [AppManager::class, 'createEquipment'])->name('equipmentform');
    Route::post('/storeEquipment', [AppManager::class, 'storeEquipment'])->name('storeequipment');
    Route::get('/editequipment/{id}', [AppManager::class, 'editEquipment'])->name('editequipment');
    Route::put('/updateequipment/{id}', [AppManager::class, 'updateEquipment'])->name('updateequipment');
    Route::delete('/deleteequipment/{id}', [AppManager::class, 'deleteEquipment'])->name('deleteequipment');
});