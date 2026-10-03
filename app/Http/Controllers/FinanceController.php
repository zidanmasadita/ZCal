<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();

        $wallets = $user->wallets;
        $activeWalletId = $request->wallet_id ?? 'all';

        if ($activeWalletId !== 'all') {
            $selectedWallet = $wallets->where('id', $activeWalletId)->first();
            $displayBalance = $selectedWallet ? $selectedWallet->balance : 0;
            $displayTitle = $selectedWallet ? $selectedWallet->name : 'Total Saldo';
        } else {
            $displayBalance = $wallets->sum('balance');
            $displayTitle = 'Total Saldo';
        }

        $query = $user->transactions()->whereBetween('date', [$startDate, $endDate]);
        if ($activeWalletId !== 'all') {
            $query->where('wallet_id', $activeWalletId);
        }
        $transactionsThisMonth = $query->get();
        $incomeThisMonth = $transactionsThisMonth->where('type', 'income')->sum('amount');
        $expenseThisMonth = $transactionsThisMonth->where('type', 'expense')->sum('amount');

        $type = $request->type ?? 'all';

        $recentQuery = $user->transactions()->with(['category', 'wallet'])->whereBetween('date', [$startDate, $endDate]);
        if ($activeWalletId !== 'all') {
            $recentQuery->where('wallet_id', $activeWalletId);
        }
        if ($type !== 'all') {
            $recentQuery->where('type', $type);
        }
        $recentTransactions = $recentQuery->latest('date')->get();

        return view('keuangan.index', compact(
            'wallets', 'displayBalance', 'displayTitle', 'incomeThisMonth', 'expenseThisMonth', 'recentTransactions', 'activeWalletId', 'type', 'startDate', 'endDate'
        ));
    }
}
