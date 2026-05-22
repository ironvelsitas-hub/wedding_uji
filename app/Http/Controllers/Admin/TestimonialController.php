<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $packages = \App\Models\Package::all();
        return view('admin.testimonials.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'couple_name' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'wedding_date' => 'nullable|date',
            'venue' => 'nullable|string|max:255',
            'package_used' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:pending,approved,rejected',
            'is_featured' => 'boolean',
            'testimonial_date' => 'nullable|date',
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('testimonials', 'public');
            $validated['photo'] = $photoPath;
        }

        $validated['is_featured'] = $request->has('is_featured');
        
        if (empty($validated['testimonial_date'])) {
            $validated['testimonial_date'] = now();
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function edit(Testimonial $testimonial)
    {
        $packages = \App\Models\Package::all();
        return view('admin.testimonials.edit', compact('testimonial', 'packages'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'couple_name' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'wedding_date' => 'nullable|date',
            'venue' => 'nullable|string|max:255',
            'package_used' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:pending,approved,rejected',
            'is_featured' => 'boolean',
            'testimonial_date' => 'nullable|date',
        ]);

        // Upload photo baru
        if ($request->hasFile('photo')) {
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $photoPath = $request->file('photo')->store('testimonials', 'public');
            $validated['photo'] = $photoPath;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diupdate');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus');
    }

    // Update status
    public function updateStatus(Request $request, Testimonial $testimonial)
    {
        $testimonial->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    // Toggle featured
    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);
        return response()->json(['success' => true, 'is_featured' => $testimonial->is_featured]);
    }
    public function verify(Testimonial $testimonial)
{
    $testimonial->update([
        'is_verified' => true,
        'status' => 'approved'
    ]);
    
    return redirect()->back()->with('success', 'Testimonial berhasil diverifikasi');
}
}