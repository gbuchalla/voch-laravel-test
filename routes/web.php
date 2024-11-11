<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;



use App\Http\Controllers\Login;
use App\Http\Controllers\Register;
use App\Http\Controllers\EconomicGroupController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;



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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/login', Login::class)->name('login');
// Route::get('/register', Register::class)->name('register');  

Route::post('/logout', function () {
    Auth::logout(); 
    return Redirect::route('login');  
})->name('logout');

Route::resources([
    'economic-groups' => EconomicGroupController::class,
    'brands' => BrandController::class,
    'units' => UnitController::class,
    'employees' => EmployeeController::class,
]);