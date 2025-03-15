<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
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



//login and registration routes
Route::get('login', function () {
    return view('authentications.login');
})->name('login.form');

Route::get('register', function () {
    return view('authentications.registration');
})->name('register.form');

Route::post('do-login', [AuthController::class, 'do_login'])->name('do-login');
Route::post('do-register', [AuthController::class, 'register'])->name('do-register');



//website routes for non authenicated users
Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');



//authenticated users routes
Route::middleware(['check.auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/favorites/add', [MovieController::class, 'add_favorites'])->name('favorites.add');
    Route::get('/dashboard', [MovieController::class, 'dashboard'])->name('dashboard');
});
