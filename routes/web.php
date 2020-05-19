<?php

use App\comment;
use Illuminate\Support\Facades\Route;

Route::livewire('/', 'home')->name('home')->middleware('auth');
Route::group(['middleware' => 'guest'], function () {
    Route::livewire('/login', 'login')->name('login');

    Route::livewire('/register', 'register')->name('register');
});
Route::get('/welcome', function () {
    return view('welcome');
});
