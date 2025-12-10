<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Club;

class ClubController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // semua user bisa lihat semua data club
        $clubs = Club::all();

        return view('backend.club.index', compact('clubs'));
    }

    public function create()
    {
        return view('backend.club.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateClub($request);
        $validated['user_id'] = Auth::id(); // simpan siapa yg input

        Club::create($validated);

        return redirect()->route('backend.club.index')->with('success', 'Club berhasil ditambahkan');
    }

    public function edit($id)
    {
        $club = Club::findOrFail($id);

        $this->authorizeClub($club);

        return view('backend.club.edit', compact('club'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $club = Club::findOrFail($id);

        $this->authorizeClub($club);

        $validated = $this->validateClub($request);

        $club->update($validated);

        return redirect()->route('backend.club.index')->with('success', 'Club berhasil diperbarui');
    }

    public function destroy($id): RedirectResponse
    {
        $club = Club::findOrFail($id);

        $this->authorizeClub($club);

        $club->delete();

        return redirect()->route('backend.club.index')->with('success', 'Club berhasil dihapus');
    }

    // ===== Helper Methods =====

    private function validateClub(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|min:2|max:255',
            'lokasi' => 'required|string|min:2|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
    }

    private function authorizeClub(Club $club): void
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return;
        }

        if ($club->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
