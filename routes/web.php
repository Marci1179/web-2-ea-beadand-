<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("mainpage", function() {return redirect('mainpage/fooldal');});
Route::get("mainpage/fooldal", function() {return View::make("fooldal");});
Route::get("mainpage/adatb", function() {return View::make("adatb");});
Route::get("mainpage/kapcsolat", function() {return View::make("kapcsolat");});
Route::get("mainpage/uzenet", function() {return View::make("uzenet");});
Route::get("mainpage/diagram", function() {return View::make("diagram");});
Route::get("mainpage/crud", function() {return View::make("crud");});