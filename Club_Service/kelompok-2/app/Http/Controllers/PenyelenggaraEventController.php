<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenyelenggaraEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PenyelenggaraEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $penyelenggara_events = PenyelenggaraEvent::latest()->get();

        return view('backend.penyelenggara_event.index', [
            'penyelenggara_events' => $penyelenggara_events,
            'user' => Auth::user(),
        ]);
    }

    public function create()
    {
        return view('backend.penyelenggara_event.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEvent($request);
        $validated['user_id'] = Auth::id();

        PenyelenggaraEvent::create($validated);

        return redirect()->route('backend.penyelenggara_event.index')
            ->with('success', 'Penyelenggara Event berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penyelenggara_event = PenyelenggaraEvent::findOrFail($id);
        $this->authorizeEvent($penyelenggara_event);

        return view('backend.penyelenggara_event.edit', compact('penyelenggara_event'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $penyelenggara_event = PenyelenggaraEvent::findOrFail($id);
        $this->authorizeEvent($penyelenggara_event);

        $validated = $this->validateEvent($request);
        $penyelenggara_event->update($validated);

        return redirect()->route('backend.penyelenggara_event.index')
            ->with('success', 'Penyelenggara Event berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $penyelenggara_event = PenyelenggaraEvent::findOrFail($id);
        $this->authorizeEvent($penyelenggara_event);

        $penyelenggara_event->delete();

        return redirect()->route('backend.penyelenggara_event.index')
            ->with('success', 'Penyelenggara Event berhasil dihapus.');
    }

    // ===== Helper Methods =====
    private function validateEvent(Request $request): array
    {
        return $request->validate([
            'nama_penyelenggara_event' => 'required|string|max:255',
            'kontak'                   => 'required|digits_between:8,15',
        ]);
    }

    private function authorizeEvent(PenyelenggaraEvent $event): void
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        if ($event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
