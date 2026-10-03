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
        if (auth()->user()->tokens()->count() >= 3) {
            return back()->with('error', 'Anda sudah mencapai batas maksimal 3 token aktif.');
        }

        $count = auth()->user()->tokens()->count() + 1;
        $name = 'Token ' . $count . ' — dibuat ' . now()->translatedFormat('j M Y, H.i');

        $token = auth()->user()->createToken($name, ['food-log:write']);

        return back()
            ->with('success', 'Token berhasil dibuat!')
            ->with('plainTextToken', $token->plainTextToken);
    }

    public function destroy(Request $request, $id)
    {
        $token = auth()->user()->tokens()->findOrFail($id);
        $token->delete();

        return back()->with('success', 'Token berhasil dicabut.');
    }
}
