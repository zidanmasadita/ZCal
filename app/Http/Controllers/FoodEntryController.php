<?php

namespace App\Http\Controllers;

use App\Models\FoodEntry;
use Illuminate\Http\Request;

class FoodEntryController extends Controller
{
    public function create()
    {
        return view('food_entries.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => ucwords(strtolower($request->name))
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'portion' => 'nullable|string|max:255',
            'calories' => 'required|integer|min:1',
            'protein' => 'nullable|integer|min:0',
            'carbs' => 'nullable|integer|min:0',
            'fat' => 'nullable|integer|min:0',
            'meal_time' => 'required|string',
            'source' => 'nullable|string'
        ]);

        auth()->user()->foodEntries()->create($request->all());

        return redirect()->route('kalori.index')->with('success', 'Catatan makanan berhasil ditambahkan!');
    }
}
