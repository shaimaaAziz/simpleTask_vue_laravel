<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
 use App\Http\Controllers\CarsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home',[HomeController::class,'index'])->name('home');
Route::post('/storeCar',[CarsController::class,'storeCar']);
Route::get('/getCars', [CarsController::class,'getCars']);
Route::post('/deleteCar/{id}', [CarsController::class,'deleteCar']);
Route::post('/editCars/{id}',[CarsController::class,'editCar']);

// Route::get('/', [BookController::class, 'index']);
Route::get('/livesearch', [BookController::class, 'getBooks']);
Route::get('/livesearch', [CarsController::class, 'getCarsSearch']);

