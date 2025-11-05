<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdatbController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    {return redirect('mainpage/fooldal');}
});

Route::get("mainpage", function() {return redirect('mainpage/fooldal');});
Route::get('mainpage/fooldal', function () {return View::make('fooldal');})->name('fooldal');
Route::get('mainpage/adatb', [AdatbController::class, 'index'])->name('adatb.index');

Route::get('mainpage/kapcsolat', [ContactController::class, 'create'])->name('kapcsolat.create');
Route::post('mainpage/kapcsolat', [ContactController::class, 'store'])->name('kapcsolat.store');

Route::middleware('auth')->group(function () {
    Route::get('mainpage/uzenet', [ContactController::class, 'index'])->name('uzenetek.index');
});
Route::get('mainpage/diagram', [DiagramController::class, 'index'])->name('diagram.index');
Route::get('/mainpage/api/diagram-data', [DiagramController::class, 'apiData'])->name('diagram.data');

Route::get("mainpage/crud", function() {return View::make("crud");});
Route::get('mainpage/crud', [PilotController::class, 'index'])->name('pilots.index');
Route::post('mainpage/crud', [PilotController::class, 'store'])->name('pilots.store');
Route::put('mainpage/crud/{pilot}', [PilotController::class, 'update'])->name('pilots.update');
Route::delete('mainpage/crud/{pilot}', [PilotController::class, 'destroy'])->name('pilots.destroy');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', RoleMiddleware::class.':admin'])
    ->get('/admin', [AdminController::class, 'index'])
    ->name('admin.dashboard');