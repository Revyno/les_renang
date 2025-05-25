<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\StudentDashboardController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Livewire\ShowContactPage;
use App\Http\Livewire\ShowHome;
use App\Http\Livewire\ShowLogin;
use App\Http\Livewire\ShowRegister;
use App\Http\Livewire\Aboutsection;
use App\Livewire\ShowBlogDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ProgramLes;


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
Route::get('/', ShowHome::class)->name('home');
Route::get('/program-les', ProgramLes::class)->name('programles');
// Route::get('/instructors', Instructors::class)->name('instructors');
// Route::get('/about', About::class)->name('about');
// Route::get('/gallery', Gallery::class)->name('gallery');
// Route::get('/blog', Blog::class)->name('blog');
// Route::get('/contact', Contact::class)->name('contact');
Route::get('/login', ShowLogin::class)->name('login');
Route::get('/register', ShowRegister::class)->name('register');
// Route::middleware(['auth'])->get('/dashboard', Dashboard::class)->name('dashboard');

// Route::prefix('admin')->group(function () {
//     \Filament\Facades\Filament::routes();
// });

// Route::get('/', ShowHome::class)->name('home');
// Route::get('/program-les', ProgramLes::class)->name('programles');
// // Route::get('/instructors', Instructors::class)->name('instructors');
// Route::get('/about', Aboutsection::class)->name('about');
// // Route::get('/blog', ShowBlogDetail::class)->name('blog');
// Route::get('/contact', ShowContactPage::class)->name('contact');
// Route::get('/login', ShowLogin::class)->name('login');
// Route::get('/register', ShowRegister::class)->name('register');

// // Admin Panel (Filament)
// // Route::prefix('admin')->group(function () {
// //     \Filament\Facades\Filament::routes();
// // });

