<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
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
Route::get('/', HomeController::class)->name('home');

// Public subpages (Inertia + React). Presentation only — see PageController.
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/layanan', [PageController::class, 'services'])->name('services');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{blog}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::post('/kontak', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');

// Auth (session-based, public site). Separate from Filament /admin guard.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');