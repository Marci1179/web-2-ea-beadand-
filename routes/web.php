<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdatbController;

Route::get('/', function () {
    return view('welcome');
});

Route::get("mainpage", function() {return redirect('mainpage/fooldal');});
Route::get("mainpage/fooldal", function() {return View::make("fooldal");});
Route::get('mainpage/adatb', [AdatbController::class, 'index'])->name('adatb.index');
Route::get("mainpage/kapcsolat", function() {return View::make("kapcsolat");});
Route::get("mainpage/uzenet", function() {return View::make("uzenet");});
Route::get("mainpage/diagram", function() {return View::make("diagram");});
Route::get("mainpage/crud", function() {return View::make("crud");});