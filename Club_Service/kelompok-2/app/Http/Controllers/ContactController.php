<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $contact = Contact::first();
        return view('backend.page_setting.contact.index', compact('contact'));
    }

    public function create()
    {
        return view('backend.page_setting.contact.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
           'address'   => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'email'     => 'required|email|max:100',
            'x' => 'nullable|url',
            'fb' => 'nullable|url',
            'ig' => 'nullable|url',
            'ln' => 'nullable|url',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Hapus data lama (karena hanya 1 data)
        Contact::truncate();

        Contact::create($validated);

        return redirect()->route('backend.contact.index')->with('success', 'Kontak berhasil ditambahkan!');
    }

    public function edit()
    {
        $contact = Contact::first();
        return view('backend.page_setting.contact.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $contact = Contact::firstOrFail();

        $validated = $request->validate([
            'address'   => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'email'     => 'required|email|max:100',
            'x' => 'nullable|url',
            'fb' => 'nullable|url',
            'ig' => 'nullable|url',
            'ln' => 'nullable|url',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);



        $contact->update($validated);

        return redirect()->route('backend.contact.index')->with('success', 'Kontak berhasil diperbarui!');
    }

    public function destroy()
    {
        $contact = Contact::first();

        if ($contact) {
            $contact->delete();
        }

        return redirect()->route('backend.contact.index')->with('success', 'Kontak berhasil dihapus!');
    }
}
