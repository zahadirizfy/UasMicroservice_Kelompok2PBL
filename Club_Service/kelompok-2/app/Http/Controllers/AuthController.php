<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        return view('authentikasi.login'); // Menyesuaikan dengan folder autentikasi dan nama file login.blade.php
    }

    // Proses autentikasi (login)
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (!Auth::user()->is_approved) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->route('backend.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    // Proses logout
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidate sesi dan regenerasi token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect('/');
    }

    public function register()
    {
        return view('authentikasi.register');
    }

    public function registerPost(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'digits_between:10,15', 'unique:users,phone_number'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:atlet,juri,klub,anggota,penyelenggara'],
        ]);

        User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => false,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan tunggu persetujuan admin.');
    }

    // Tampilkan form lupa password
    public function showForgotForm()
    {
        return view('authentikasi.forgot-password');
    }

    // Tangani form input email dan nomor HP
    public function handleForgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->where('phone_number', $request->phone)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email dan nomor HP tidak cocok.'])->withInput();
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = route('password.reset', $token);

        return view('authentikasi.forgot-password', ['resetLink' => $resetLink]);
    }

    // Tampilkan form buat password baru
    public function showResetForm($token)
    {
        return view('authentikasi.reset-password', ['token' => $token]);
    }

    // Simpan password baru
    public function handleReset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil direset.');
    }
}
