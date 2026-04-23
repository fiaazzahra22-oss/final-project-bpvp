<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ZoneController extends Controller
{
    public function index()
    {
        $zones=Zone::all();
        return view('admin.pages.zones.index', compact('zones'));
    }
    public function create()
    {
        return view('admin.pages.zones.create');
    }

    public function store(Request $request)
    {
        
       $validated=  $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price_range' => 'required',
        'image'       => 'required|image|',
    ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image','public');
            $validated['image'] = basename($imagePath);
        }

        Zone::create($validated);
        return redirect()->route('admin.zones.index')->with('success'. 'Zone created successfully.');
    }

    public function show($id)
    {
        return view('admin.pages.zones.show');
    }

    public function edit($id)
    {
        return view('admin.pages.zones.edit');
    }

    public function update(Request $request, $id)
    {
         $validated = $request->validate([
        'name' => 'required',
        'description' => 'nullable',
        'price_range' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $zone = Zone::findOrFail($id);

        if ($zone->image && $request->hasFile('image')) {
            Storage::disk('public')->delete('images/' . $zone->image);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = basename($imagePath);
        }

        $zone->update($validated);

        return redirect('/admin/zones')->with('success', 'Zone updated success');
    }

    public function destroy($id)
    {
        $zone = Zone::find($id);

        if ($zone) {
            $zone->delete();
            return redirect()->route('admin.zones.index')
                ->with('success', 'Zone deleted successfully.');
        }
    }
}
