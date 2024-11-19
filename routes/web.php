<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\EconomicGroupController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuditController;

use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


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


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);



Route::get('/audits', [AuditController::class, 'index'])->name('audits');

Route::middleware(['auth'])->group(function () {

   // Homepage 
    Route::get('/', [HomeController::class, 'index'])->name('home');

    
    // Download reports routes
    Route::get('/employees/export', function (Request $request) {
        return Excel::download(new EmployeeExport, 'colaboradores'.Carbon::now('America/Sao_Paulo')->format('d-m-Y_H-i-s').'.xlsx');
    })->name('employees.export');
    

    // rotas CRUD para as principais resources
    Route::resources([
        'economic-groups' => EconomicGroupController::class,
        'brands' => BrandController::class,
        'units' => UnitController::class,
        'employees' => EmployeeController::class,
    ]);

    

});


