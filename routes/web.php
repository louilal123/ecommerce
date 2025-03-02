<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password')->middleware('password.confirm');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    //add the products rout 
    Volt::route('products', 'products')->name('products');
});

require __DIR__.'/auth.php';
