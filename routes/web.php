<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Route to display the index page for offices
Route::get('/offices', [OfficeController::class, 'index'])->name('offices.index');

// Route to view a specific office
Route::get('/offices/{id}', [OfficeController::class, 'view'])->name('offices.view');

// Route to get list of colleague
Route::get('/offices/{office}/colleagues', [OfficeController::class, 'getColleagues'])->name('offices.colleagues');
