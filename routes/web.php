<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ReviewsController;
use App\Models\Zone;
use App\Models\Attraction;



Route::prefix('/')->name('landing.')->group(function () {
    Route::get('/', function () {
        $zones = Zone::all();
        $attractions = Attraction::all();
        route:
        return view('landing.pages.index', compact('zones', 'attractions'));
    })->name('index');
    Route::prefix('/attraction')->group(function () {
        Route::get('/{attraction}', [AttractionController::class, 'showAttractions'])->name('attraction');
        Route::post('/review', [ReviewsController::class, 'store'])->name('attraction.review.store');
    });

    Route::prefix('/zone')->group(function () {
        Route::get('/{zone}', [ZoneController::class, 'showZones'])->name('zone');
        Route::post('/review', [ReviewsController::class, 'store'])->name('.review.store');
    });
});

Route::get('/detail', function () {
    return view('landing.pages.detail');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        $zones = \App\Models\Zone::all();
        $attraction = \App\Models\Attraction::all();
        $publishedReviews = \App\Models\Review::where('is_published', true)->get();
        $unpublishedReviews = \App\Models\Review::where('is_published', false)->get();
        $counter = [
            'zones' => $zones->count(),
            'attractions' => $attraction->count(),
            'publishedReviews' => $publishedReviews->count(),
            'unpublishedReviews' => $unpublishedReviews->count(),
        ];
        return view(view: 'admin.pages.index', data: compact('counter'));
    })->name('index');
    Route::resource('zones', ZoneController::class);
    Route::resource('attractions', AttractionController::class);
    Route::get('reviews', [ReviewsController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/approve', [ReviewsController::class, 'approve'])->name('reviews.approve');
    Route::patch('reviews/{review}/disapprove', [ReviewsController::class, 'disapprove'])->name('reviews.disapprove');
    Route::delete('reviews/{review}', [ReviewsController::class, 'destroy'])->name('reviews.destroy');
    Route::resource('reviews', ReviewsController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
