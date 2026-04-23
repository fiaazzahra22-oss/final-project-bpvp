<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ReviewsController;
use App\Models\Zone;
use App\Models\Attraction;

Route::get('/', function () {
    $zones = Zone::all();
    return view('landing.pages.index', compact('zones'));
});

Route::get('/detail', function () {
    return view('landing.pages.detail');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
    return view('admin.pages.index');
    })->name('index');
    Route::resource('zones', ZoneController::class);
    Route::resource('attractions',AttractionController::class);
    Route::resource('reviews', ReviewsController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
