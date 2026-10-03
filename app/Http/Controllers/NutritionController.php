<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NutritionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $foodsToday = $user->foodEntries()->whereDate('created_at', $today)->latest('created_at')->get();
        $caloriesToday = $foodsToday->sum('calories');
        $proteinToday = $foodsToday->sum('protein');
        $carbsToday = $foodsToday->sum('carbs');
        $fatToday = $foodsToday->sum('fat');

        return view('kalori.index', compact(
            'foodsToday', 'caloriesToday', 'proteinToday', 'carbsToday', 'fatToday'
        ));
    }
}
