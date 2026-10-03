<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class MuseTokenController extends Controller
{
    public function index()
    {
        $tokens = auth()->user()->tokens;
        return view('settings.muse', compact('tokens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $token = auth()->user()->createToken($request->name, ['food-log:write']);

        return redirect()->route('settings.muse.index')
            ->with('success', 'Token berhasil dibuat. Simpan token ini karena tidak akan ditampilkan lagi!')
            ->with('plainTextToken', $token->plainTextToken);
    }

    public function destroy(Request $request, $id)
    {
        $token = auth()->user()->tokens()->findOrFail($id);
        $token->delete();

        return redirect()->route('settings.muse.index')->with('success', 'Token berhasil dicabut.');
    }
}
