<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PearsonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PearsonController::class, 'index']);
Route::get('/pearson/{id}', [PearsonController::class, 'getPearson'])->name('getPearson');
Route::post('/pearson', [PearsonController::class, 'store'])->name('storePearson');
Route::post('/pearson/edit', [PearsonController::class, 'update'])->name('editPearson');
Route::post('/contact', [ContactController::class, 'store'])->name('storeContact');
