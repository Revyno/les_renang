<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web Routes (Inertia + React)
|--------------------------------------------------------------------------
| Route names are preserved from the previous Livewire setup so existing
| links keep working. The Filament admin panel lives at /admin (untouched).
*/

Route::get('/', [PageController::class, 'home'])->name('Home');
Route::get('/services', [PageController::class, 'services'])->name('Service');
Route::get('/service/{id}', [PageController::class, 'serviceShow'])->whereNumber('id')->name('ServiceDetail');
Route::get('/about-us', [PageController::class, 'about'])->name('AboutUs');
Route::get('/ourteams', [PageController::class, 'team'])->name('team');
Route::get('/blogs', [PageController::class, 'blogs'])->name('Blog');
Route::get('/blog-detail/{id}', [PageController::class, 'blogShow'])->whereNumber('id')->name('BlogDetail');
Route::get('/faqs', [PageController::class, 'faq'])->name('FAQ');
Route::get('/contactus', [PageController::class, 'contact'])->name('Contact');
Route::post('/contactus', [ContactController::class, 'submit'])->name('Contact.submit');
