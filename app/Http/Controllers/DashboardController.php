<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // 1. Kalori Hari Ini
        $foodsToday = $user->foodEntries()->whereDate('created_at', $today)->get();
        $caloriesToday = $foodsToday->sum('calories');
        $proteinToday = $foodsToday->sum('protein');
        $carbsToday = $foodsToday->sum('carbs');
        $fatToday = $foodsToday->sum('fat');

        // 2. Keuangan
        $totalBalance = $user->wallets()->sum('balance');
        $transactionsThisMonth = $user->transactions()->where('date', '>=', $thisMonth)->get();
        $incomeThisMonth = $transactionsThisMonth->where('type', 'income')->sum('amount');
        $expenseThisMonth = $transactionsThisMonth->where('type', 'expense')->sum('amount');

        // 3. Aktivitas Terakhir (Mixed)
        $recentTransactions = $user->transactions()->with(['category', 'wallet'])->latest('date')->take(5)->get()->map(function($tx) {
            $tx->activity_type = 'transaction';
            $tx->timestamp = Carbon::parse($tx->date);
            return $tx;
        });

        $recentFoods = $user->foodEntries()->latest('created_at')->take(5)->get()->map(function($food) {
            $food->activity_type = 'food';
            $food->timestamp = $food->created_at;
            return $food;
        });

        // Merge and sort
        $recentActivities = $recentTransactions->concat($recentFoods)->sortByDesc('timestamp')->take(5);

        return view('dashboard', compact(
            'caloriesToday', 'proteinToday', 'carbsToday', 'fatToday',
            'totalBalance', 'incomeThisMonth', 'expenseThisMonth',
            'recentActivities'
        ));
    }
}
