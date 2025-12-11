<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $testimonials = Testimonial::all();
        return view('backend.page_setting.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('backend.page_setting.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'quote'      => 'required|string|max:500',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // pastikan folder upload ada
        if (!File::exists(public_path('uploads/testimonials'))) {
            File::makeDirectory(public_path('uploads/testimonials'), 0755, true);
        }

        $testimonial = new Testimonial($validated);

        if ($request->hasFile('image')) {
            $filename = time() . '_img.' . $request->image->extension();
            $request->image->move(public_path('uploads/testimonials'), $filename);
            $testimonial->image = $filename;
        }

        $testimonial->save();

        return redirect()->route('backend.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('backend.page_setting.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'quote'      => 'required|string|max:500',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (!File::exists(public_path('uploads/testimonials'))) {
            File::makeDirectory(public_path('uploads/testimonials'), 0755, true);
        }

        if ($request->hasFile('image')) {
            // hapus lama
            $oldPath = public_path('uploads/testimonials/' . $testimonial->image);
            if ($testimonial->image && File::exists($oldPath)) {
                File::delete($oldPath);
            }
            // simpan baru
            $filename = time() . '_img.' . $request->image->extension();
            $request->image->move(public_path('uploads/testimonials'), $filename);
            $testimonial->image = $filename;
        }

        $testimonial->update($validated);

        return redirect()->route('backend.testimonials.index')->with('success', 'Testimonial berhasil diperbarui!');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) {
            $path = public_path('uploads/testimonials/' . $testimonial->image);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $testimonial->delete();

        return back()->with('success', 'Testimonial berhasil dihapus!');
    }
}
