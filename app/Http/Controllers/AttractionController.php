<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Zone;

class AttractionController extends Controller
{
    public function index()
    {
        $attractions = Attraction::all();
        return view('admin.pages.attraction.index', compact('attractions'));
    }

    public function create()
    {
        $zones = Zone::all();

        // FIX: kirim ke view
        return view('admin.pages.attraction.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // FIX: harus integer + relasi valid
            'zone_id' => 'required|integer|exists:zones,id',
            'name' => 'required',
            'description' => 'required',
            'price_range' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        // upload image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = basename($imagePath);
        }

        Attraction::create($validated);

        return redirect()
            ->route('admin.attractions.index')
            ->with('success', 'Attraction created successfully.');
    }

    public function show($id)
    {
        $attraction = Attraction::findOrFail($id);
        return view('admin.pages.attraction.show', compact('attraction'));
    }

    public function edit($id)
    {
        $attraction = Attraction::findOrFail($id);
        $zones = Zone::all();

        return view('admin.pages.attraction.edit', compact('attraction', 'zones'));
    }

    public function update(Request $request, $id)
    {
        $attraction = Attraction::findOrFail($id);

        $validated = $request->validate([
            'zone_id' => 'required|integer|exists:zones,id',
            'name' => 'required',
            'description' => 'nullable',
            'price_range' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        // delete old image
        if ($request->hasFile('image')) {
            if ($attraction->image) {
                Storage::disk('public')->delete('images/' . $attraction->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = basename($imagePath);
        }

        $attraction->update($validated);

        return redirect()
            ->route('admin.attractions.index')
            ->with('success', 'Attraction updated successfully');
    }

    public function destroy($id)
    {
        $attraction = Attraction::findOrFail($id);

        if ($attraction->image) {
            Storage::disk('public')->delete('images/' . $attraction->image);
        }

        $attraction->delete();

        return redirect()
            ->route('admin.attractions.index')
            ->with('success', 'Attraction deleted successfully.');
    }
}