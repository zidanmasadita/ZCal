<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $otp = rand(100000, 999999);
        \Illuminate\Support\Facades\Cache::put('password_reset_otp_' . $request->email, $otp, now()->addMinutes(15));

        \Illuminate\Support\Facades\Mail::raw("Kode OTP Anda untuk mereset password adalah: {$otp}\nKode ini berlaku selama 15 menit.", function($msg) use ($request) {
            $msg->to($request->email)->subject('Kode Reset Password - ZCal');
        });

        return redirect()->route('password.reset', ['token' => 'otp', 'email' => $request->email])
                         ->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }
}
