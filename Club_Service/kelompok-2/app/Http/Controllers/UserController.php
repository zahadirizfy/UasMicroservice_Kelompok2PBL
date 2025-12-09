<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan daftar semua user (kecuali admin)

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('backend.users.index', compact('users'));
    }

    // Menghapus user tertentu
    public function destroy(User $user)
{
    // Cegah penghapusan admin
    if ($user->role === 'admin') {
        return redirect()->route('backend.users.index')->with('error', 'User dengan role admin tidak bisa dihapus.');
    }

    $user->delete();
    return redirect()->route('backend.users.index')->with('success', 'User berhasil dihapus.');
}

}
