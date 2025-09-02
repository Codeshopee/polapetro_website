<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CareerController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact pages
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1') // Rate limiting: 5 requests per minute
    ->name('contact.store');

// Alternative contact routes
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.show');
Route::get('/hubungi-kami', [ContactController::class, 'index'])->name('contact.id');

// Career pages - URUTAN PENTING!
Route::get('/careers', [CareerController::class, 'index'])->name('careers');
Route::get('/careers/{slug}', [CareerController::class, 'show'])->name('careers.show');
Route::post('/careers/{slug}', [CareerController::class, 'submitApplication'])->name('careers.submit');