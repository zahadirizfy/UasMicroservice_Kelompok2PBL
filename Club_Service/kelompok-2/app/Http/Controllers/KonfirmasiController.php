<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KonfirmasiController extends Controller
{
    // Tampilkan semua user yang belum disetujui
    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->get();
        return view('backend.konfirmasi.index', compact('pendingUsers'));
    }

    // Setujui akun
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil disetujui.');
    }
}
