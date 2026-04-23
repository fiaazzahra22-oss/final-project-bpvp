<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('admin.pages.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.pages.reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewer' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create($validated);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    public function show(int $id)
    {
        $review = Review::findOrFail($id);
        return view('admin.pages.reviews.show', compact('review'));
    }

    public function edit(int $id)
    {
        $review = Review::findOrFail($id);
        return view('admin.pages.reviews.edit', compact('review'));
    }

    public function update(Request $request, int $id)
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'reviewer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($validated);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review updated successfully');
    }

    public function destroy(int $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}