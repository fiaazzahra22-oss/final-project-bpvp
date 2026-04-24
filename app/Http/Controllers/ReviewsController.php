<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Attraction;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::with('attraction')->latest()->get();
        return view('admin.pages.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $attractions = Attraction::all(); // buat dropdown
        return view('admin.pages.reviews.create', compact('attractions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewer' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'attraction_id' => 'required|exists:attractions,id',
        ]);

        Review::create($validated);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    public function show($id)
    {
        $review = Review::with('attraction')->findOrFail($id);
        return view('admin.pages.reviews.show', compact('review'));
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $attractions = Attraction::all();

        return view('admin.pages.reviews.edit', compact('review', 'attractions'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'reviewer' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'attraction_id' => 'required|exists:attractions,id',
        ]);

        $review->update($validated);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}