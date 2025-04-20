<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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


Route::get('/',[AuthController::class,'login']);
Route::get('login', 'App\Http\Controllers\Auth\AuthController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\AuthController@login');
Route::post('logout', 'App\Http\Controllers\Auth\AuthController@logout')->name('logout');

Route::get('/', function () {
    return view('welcome');
});
// Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
//     Route::resource('registrations', App\Http\Controllers\Admin\RegistrationController::class);
//     Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);
//     Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);
//     Route::resource('instructors', App\Http\Controllers\Admin\InstructorController::class);
//     Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
//     Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
//     Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
// });

// Route::get('/', function () {
//     return view('admin');
// });
// Route::get('/',[HomeController::class,'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
