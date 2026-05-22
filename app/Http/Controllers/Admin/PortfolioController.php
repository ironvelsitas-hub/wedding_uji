<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(12);
        return view('admin.portfolio.index', compact('portfolios'));
    }

    public function create()
    {
        $categories = [
            'wedding' => 'Pernikahan',
            'engagement' => 'Tunangan',
            'prewedding' => 'Pre-wedding',
            'reception' => 'Resepsi',
            'traditional' => 'Adat',
        ];
        return view('admin.portfolio.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'is_featured' => 'boolean',
            'video_url' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Multiple images
        ]);

        // Upload main image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = $imagePath;
        }

        // Upload gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $galleryImage) {
                $path = $galleryImage->store('portfolio/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $validated['gallery'] = $galleryPaths;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = Str::slug($request->title);

        Portfolio::create($validated);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio berhasil ditambahkan');
    }

    public function edit(Portfolio $portfolio)
    {
        $categories = [
            'wedding' => 'Pernikahan',
            'engagement' => 'Tunangan',
            'prewedding' => 'Pre-wedding',
            'reception' => 'Resepsi',
            'traditional' => 'Adat',
        ];
        return view('admin.portfolio.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'is_featured' => 'boolean',
            'video_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Update main image
        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $imagePath = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = $imagePath;
        }

        // Update gallery images
        if ($request->hasFile('gallery')) {
            // Hapus gallery lama
            if ($portfolio->gallery) {
                foreach ($portfolio->gallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $galleryPaths = [];
            foreach ($request->file('gallery') as $galleryImage) {
                $path = $galleryImage->store('portfolio/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $validated['gallery'] = $galleryPaths;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $portfolio->update($validated);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio berhasil diupdate');
    }

    public function destroy(Portfolio $portfolio)
    {
        // Hapus main image
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }
        
        // Hapus gallery images
        if ($portfolio->gallery) {
            foreach ($portfolio->gallery as $galleryImage) {
                Storage::disk('public')->delete($galleryImage);
            }
        }
        
        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio berhasil dihapus');
    }

    // Toggle featured status
    public function toggleFeatured(Portfolio $portfolio)
    {
        $portfolio->update(['is_featured' => !$portfolio->is_featured]);
        return response()->json(['success' => true, 'is_featured' => $portfolio->is_featured]);
    }
}