<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdatbController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    {return redirect('mainpage/fooldal');}
});

Route::get("mainpage", function() {return redirect('mainpage/fooldal');});
Route::get("mainpage/fooldal", function() {return View::make("fooldal");});
Route::get('mainpage/adatb', [AdatbController::class, 'index'])->name('adatb.index');
Route::get('mainpage/kapcsolat', [ContactController::class, 'create'])->name('kapcsolat.create');
Route::post('mainpage/kapcsolat', [ContactController::class, 'store'])->name('kapcsolat.store');
Route::get('mainpage/uzenet', [ContactController::class, 'index'])->name('uzenetek.index');
Route::get("mainpage/diagram", function() {return View::make("diagram");});
Route::get("mainpage/crud", function() {return View::make("crud");});