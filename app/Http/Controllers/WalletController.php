<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Auth::user()->wallets;
        return view('wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => ucwords(strtolower($request->name)),
            'balance' => str_replace('.', '', $request->balance)
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
        ]);

        Wallet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        return redirect()->route('transactions.create')->with('success', 'Dompet baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $wallet = Auth::user()->wallets()->findOrFail($id);
        
        // Cek apakah dompet sudah digunakan untuk transaksi
        if ($wallet->transactions()->count() > 0) {
            return redirect()->route('wallets.index')->with('error', 'Dompet tidak bisa dihapus karena sudah ada riwayat transaksi. Hapus transaksinya dulu ya!');
        }

        $wallet->delete();

        return redirect()->route('wallets.index')->with('success', 'Dompet berhasil dihapus!');
    }
}
