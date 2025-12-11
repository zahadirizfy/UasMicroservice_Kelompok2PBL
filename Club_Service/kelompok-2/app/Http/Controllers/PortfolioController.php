<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $portfolios = Portfolio::all();
        return view('backend.page_setting.portfolio.index', compact('portfolios'));
    }

    public function create()
    {
        return view('backend.page_setting.portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('uploads/portfolio', 'public');
        $validated['image'] = 'storage/' . $path;

        Portfolio::create($validated);

        return redirect()->route('backend.portfolio.index')->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('backend.page_setting.portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($portfolio->image && Storage::disk('public')->exists(str_replace('storage/', '', $portfolio->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $portfolio->image));
            }
            $path = $request->file('image')->store('uploads/portfolio', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $portfolio->update($validated);

        return redirect()->route('backend.portfolio.index')->with('success', 'Portfolio berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        if ($portfolio->image && Storage::disk('public')->exists(str_replace('storage/', '', $portfolio->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $portfolio->image));
        }

        $portfolio->delete();

        return redirect()->route('backend.portfolio.index')->with('success', 'Portfolio berhasil dihapus!');
    }
}
