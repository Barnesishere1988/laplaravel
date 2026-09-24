<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AccountController;

Route::get("/", function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('signin');
});


Route::middleware(['guest'])->group(function () {

Route::get("/signin", [UserController::class, 'index'])->name('signin');

Route::get("/signup", [UserController::class, 'create'])->name('signup');

Route::post("/signup", [UserController::class, 'store'])->name("signup.store");

Route::post('/login', [UserController::class, 'login'])->name('login');

});



Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    Route::get('/signout', [UserController::class, 'logout'])->name('signout');

    // Account-Seite anzeigen
    Route::get(
        '/account',
        [AccountController::class, 'index']
    )->name('account');

    // Accountdaten speichern
    Route::patch(
        '/account',
        [AccountController::class, 'update']
    )->name('account.update');

    // Passwort ändern
    Route::patch(
        '/account/password',
        [AccountController::class, 'updatePassword']
    )->name('account.password.update');

    // Profilbild hochladen
    Route::post(
        '/account/image',
        [AccountController::class, 'updateImage']
    )->name('account.image.update');

    // Profilbild löschen
    Route::delete(
        '/account/image',
        [AccountController::class, 'deleteImage']
    )->name('account.image.delete');
});

Route::middleware(['admin'])->group(function () {

    Route::post('/todos', [
        TodoController::class,
        'store'
    ])->name('todos.store');

    Route::patch('/todos/{todo}', [
        TodoController::class,
        'update'
    ])->name('todos.update');

    Route::delete('/todos/{todo}', [
        TodoController::class,
        'destroy'
    ])->name('todos.destroy');

});