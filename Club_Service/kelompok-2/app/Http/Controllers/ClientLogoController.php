<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientLogoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $logos = ClientLogo::all();
        return view('backend.page_setting.clientlogos.index', compact('logos'));
    }

    public function create()
    {
        return view('backend.page_setting.clientlogos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,svg|max:15000',
        ]);

        $path = $request->file('logo')->store('uploads/client_logos', 'public');

        ClientLogo::create([
            'logo' => 'storage/' . $path,
        ]);

        return redirect()->route('backend.clientlogos.index')->with('success', 'Logo berhasil ditambahkan.');
    }

    public function edit($id)
    {
       $clientlogo = ClientLogo::findOrFail($id);
return view('backend.page_setting.clientlogos.edit', compact('clientlogo'));

    }

    public function update(Request $request, $id)
    {
        $logo = ClientLogo::findOrFail($id);

        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:15000',
        ]);

        // Hapus gambar lama jika ada upload baru
        if ($request->hasFile('logo')) {
            if ($logo->logo && file_exists(public_path($logo->logo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $logo->logo));
            }

            $path = $request->file('logo')->store('uploads/client_logos', 'public');
            $logo->logo = 'storage/' . $path;
        }

        $logo->save();

        return redirect()->route('backend.clientlogos.index')->with('success', 'Logo berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $logo = ClientLogo::findOrFail($id);

        if ($logo->logo && file_exists(public_path($logo->logo))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $logo->logo));
        }

        $logo->delete();

        return redirect()->route('backend.clientlogos.index')->with('success', 'Logo berhasil dihapus.');
    }
}
