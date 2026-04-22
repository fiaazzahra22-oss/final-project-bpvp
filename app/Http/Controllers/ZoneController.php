<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

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
        // Update the zone logic here
    }

    public function destroy($id)
    {
        // Delete the zone logic here
    }
}
