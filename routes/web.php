<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleRequestController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('login');
});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->hasRole('driver')) {
            $vehicles = $user->vehicles;
            return view('dashboard.driver',compact('vehicles'));
        }

        if ($user->hasRole('staff')) {
            return view('dashboard.staff');
        }

        if ($user->hasRole('admin')) {
            return view('dashboard.admin');
        }
    })->name('dashboard');

    Route::resource('user', UserController::class);
    Route::resource('vehicle', VehicleController::class);
    Route::resource('vehicleRequest', VehicleRequestController::class);
});

require __DIR__ . '/auth.php';
