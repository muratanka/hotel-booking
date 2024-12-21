<?php

use Illuminate\Support\Facades\Route;

// Varsayılan dil yönlendirmesi
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Diğer diller için yönlendirme
Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('localized.home');
});
