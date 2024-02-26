<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OfficeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logoutWithGet'])->name('logoutWithGet');

// Route to display the index page for offices
Route::get('/offices', [OfficeController::class, 'index'])->name('offices.index');

// Route to view a specific office
Route::get('/offices/{id}', [OfficeController::class, 'view'])->name('offices.view');

// Route to get list of colleague
Route::get('/offices/{office}/colleagues', [OfficeController::class, 'getColleagues'])->name('offices.colleagues');

// Route to display the edit office form
Route::get('/offices/{office}/edit', [OfficeController::class, 'edit'])->name('offices.edit');

// Route to update office and colleague data
Route::put('/offices/{office}', [OfficeController::class, 'update'])->name('offices.update');

// Colleague routes
Route::put('/colleagues/{officeId}', [OfficeController::class, 'colleagueUpdate'])->name('colleagues.update');

Route::delete('/offices/delete/{id}', [OfficeController::class, 'delete'])->name('offices.delete');
