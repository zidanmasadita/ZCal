<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        if ($user->wallets()->count() === 0) {
            $user->wallets()->createMany([
                ['name' => 'Tunai', 'balance' => 0]
            ]);
        }
        if ($user->categories()->count() === 0) {
            $user->categories()->createMany([
                ['type' => 'income', 'name' => 'Gaji', 'icon' => 'icon-uang-masuk.png'],
                ['type' => 'income', 'name' => 'Lainnya', 'icon' => 'icon-uang-masuk.png'],
                ['type' => 'expense', 'name' => 'Makan', 'icon' => 'icon-makanan.png'],
                ['type' => 'expense', 'name' => 'Transport', 'icon' => 'icon-kendaraan.png'],
                ['type' => 'expense', 'name' => 'Minuman', 'icon' => 'icon-minuman.png'],
                ['type' => 'expense', 'name' => 'Lainnya', 'icon' => 'icon-uang-pengeluaran.png'],
            ]);
        }
        
        $wallets = $user->wallets;
        $categories = $user->categories;
        return view('transactions.create', compact('wallets', 'categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'amount' => str_replace('.', '', $request->amount),
            'note' => $request->note ? ucwords(strtolower($request->note)) : null
        ]);

        $request->validate([
            'wallet_id' => ['required', \Illuminate\Validation\Rule::exists('wallets', 'id')->where('user_id', auth()->id())],
            'category_id' => ['required', \Illuminate\Validation\Rule::exists('categories', 'id')->where('user_id', auth()->id())],
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        DB::transaction(function() use ($request) {
            $user = auth()->user();
            $transaction = $user->transactions()->create($request->all());

            $wallet = Wallet::findOrFail($request->wallet_id);
            if ($request->type === 'income') {
                $wallet->balance += $request->amount;
            } else {
                $wallet->balance -= $request->amount;
            }
            $wallet->save();
        });

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil disimpan!');
    }
}
