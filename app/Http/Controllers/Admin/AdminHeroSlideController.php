<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class AdminHeroSlideController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $slides = HeroSlide::ordered()->get();
        return view('admin.hero_slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero_slides.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|max:200',
            'description' => 'nullable|max:500',
            'icon'        => 'nullable|max:50',
            'image'       => 'nullable|image|max:3072',
            'button_text' => 'nullable|max:100',
            'button_url'  => 'nullable|max:300',
            'order'       => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeWebP($request->file('image'), 'hero_slides', 1200);
        }

        $count = HeroSlide::count();
        if ($count >= 5) {
            return back()->withErrors(['limit' => 'Maksimal 5 slide diperbolehkan.'])->withInput();
        }

        HeroSlide::create($validated);
        return redirect()->route('admin.hero_slides.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero_slides.form', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'title'       => 'required|max:200',
            'description' => 'nullable|max:500',
            'icon'        => 'nullable|max:50',
            'image'       => 'nullable|image|max:3072',
            'button_text' => 'nullable|max:100',
            'button_url'  => 'nullable|max:300',
            'order'       => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $this->deleteStorageFile($heroSlide->image);
            $validated['image'] = $this->storeWebP($request->file('image'), 'hero_slides', 1200);
        }

        $heroSlide->update($validated);
        return redirect()->route('admin.hero_slides.index')->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $this->deleteStorageFile($heroSlide->image ?? null);
        $heroSlide->delete();
        return back()->with('success', 'Slide berhasil dihapus.');
    }
}
