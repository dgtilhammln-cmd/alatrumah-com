<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class AdminServiceController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $services = Service::ordered()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create() { return view('admin.services.create'); }

    public function store(Request $request)
    {
        $v = $request->validate([
            'name'          => 'required|max:200',
            'slug'          => 'nullable|max:200|regex:/^[a-z0-9\-]*$/',
            'short_desc'    => 'nullable|max:500',
            'description'   => 'nullable',
            'icon'          => 'nullable|max:50',
            'order'         => 'nullable|integer|min:0',
            'is_active'     => 'boolean',
            'meta_title'    => 'nullable|max:70',
            'meta_desc'     => 'nullable|max:165',
            'meta_keywords' => 'nullable|max:500',
            'image'         => 'nullable|image|max:5120',
            'brochure'      => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'og_image'      => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120',
            'spec_keys'     => 'nullable|array',
            'spec_keys.*'   => 'nullable|string|max:255',
            'spec_values'   => 'nullable|array',
            'spec_values.*' => 'nullable|string|max:1000',
            'faq_qs'        => 'nullable|array',
            'faq_qs.*'      => 'nullable|string|max:500',
            'faq_as'        => 'nullable|array',
            'faq_as.*'      => 'nullable|string|max:2000',
        ]);

        // Slug
        $slug = Str::slug(!empty($v['slug']) ? $v['slug'] : $v['name']);
        $base = $slug; $i = 1;
        while (Service::where('slug', $slug)->exists()) { $slug = $base.'-'.$i++; }
        $v['slug'] = $slug;

        $v['is_active'] = $request->boolean('is_active', true);
        $v['order']     = $v['order'] ?? 0;

        if (empty($v['meta_title'])) $v['meta_title'] = $v['name'].' | Cyclevent';
        if (empty($v['meta_desc']))  $v['meta_desc']  = Str::limit(strip_tags($v['short_desc'] ?? ''), 155);

        if ($request->hasFile('image')) {
            $v['image'] = $this->storeWebP($request->file('image'), 'services', 1200, 800);
            if (!$request->hasFile('og_image')) {
                $v['og_image'] = $this->storeOgWebP($request->file('image'), 'services/og');
            }
        }
        if ($request->hasFile('og_image')) {
            $v['og_image'] = $this->storeOgWebP($request->file('og_image'), 'services/og');
        }

        if ($request->hasFile('brochure')) {
            $v['brochure'] = $request->file('brochure')->store('brochures', 'public');
        }

        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->storeWebP($file, 'services/gallery', 1200, 800);
            }
        }
        $v['gallery'] = $gallery;

        // Process Specs
        $specs = [];
        $specKeys = $request->input('spec_keys', []);
        $specValues = $request->input('spec_values', []);
        foreach ($specKeys as $idx => $key) {
            if (!empty($key) && isset($specValues[$idx])) {
                $specs[] = ['key' => $key, 'value' => $specValues[$idx]];
            }
        }
        $v['specifications'] = $specs;

        // Process FAQs
        $faqs = [];
        $faqQs = $request->input('faq_qs', []);
        $faqAs = $request->input('faq_as', []);
        foreach ($faqQs as $idx => $q) {
            if (!empty($q) && isset($faqAs[$idx])) {
                $faqs[] = ['q' => $q, 'a' => $faqAs[$idx]];
            }
        }
        $v['faqs'] = $faqs;

        Service::create($v);
        Cache::forget('home_page_data');
        Cache::forget('services_page_data');
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service) { return view('admin.services.edit', compact('service')); }

    public function update(Request $request, Service $service)
    {
        $v = $request->validate([
            'name'          => 'required|max:200',
            'slug'          => 'nullable|max:200|regex:/^[a-z0-9\-]*$/',
            'short_desc'    => 'nullable|max:500',
            'description'   => 'nullable',
            'icon'          => 'nullable|max:50',
            'order'         => 'nullable|integer|min:0',
            'is_active'     => 'boolean',
            'meta_title'    => 'nullable|max:70',
            'meta_desc'     => 'nullable|max:165',
            'meta_keywords' => 'nullable|max:500',
            'image'         => 'nullable|image|max:5120',
            'brochure'      => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'og_image'      => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120',
            'spec_keys'     => 'nullable|array',
            'spec_keys.*'   => 'nullable|string|max:255',
            'spec_values'   => 'nullable|array',
            'spec_values.*' => 'nullable|string|max:1000',
            'faq_qs'        => 'nullable|array',
            'faq_qs.*'      => 'nullable|string|max:500',
            'faq_as'        => 'nullable|array',
            'faq_as.*'      => 'nullable|string|max:2000',
        ]);

        // Slug update
        if (!empty($v['slug'])) {
            $slug = Str::slug($v['slug']);
            $base = $slug; $i = 1;
            while (Service::where('slug', $slug)->where('id','!=',$service->id)->exists()) { $slug = $base.'-'.$i++; }
            $v['slug'] = $slug;
        }

        $v['is_active'] = $request->boolean('is_active', true);
        $v['order']     = $v['order'] ?? $service->order;

        if ($request->hasFile('image')) {
            $this->deleteStorageFile($service->image);
            $v['image'] = $this->storeWebP($request->file('image'), 'services', 1200, 800);
            if (!$request->hasFile('og_image') && !$service->og_image) {
                $v['og_image'] = $this->storeOgWebP($request->file('image'), 'services/og');
            }
        }
        if ($request->hasFile('og_image')) {
            $this->deleteStorageFile($service->og_image);
            $v['og_image'] = $this->storeOgWebP($request->file('og_image'), 'services/og');
        }

        if ($request->hasFile('brochure')) {
            $this->deleteStorageFile($service->brochure);
            $v['brochure'] = $request->file('brochure')->store('brochures', 'public');
        }

        $gallery = is_array($service->gallery) ? $service->gallery : [];
        if ($request->has('delete_gallery')) {
            foreach ($request->input('delete_gallery') as $delImg) {
                $this->deleteStorageFile($delImg);
                if (($key = array_search($delImg, $gallery)) !== false) {
                    unset($gallery[$key]);
                }
            }
            $gallery = array_values($gallery);
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->storeWebP($file, 'services/gallery', 1200, 800);
            }
        }
        $v['gallery'] = $gallery;

        // Process Specs
        $specs = [];
        $specKeys = $request->input('spec_keys', []);
        $specValues = $request->input('spec_values', []);
        foreach ($specKeys as $idx => $key) {
            if (!empty($key) && isset($specValues[$idx])) {
                $specs[] = ['key' => $key, 'value' => $specValues[$idx]];
            }
        }
        $v['specifications'] = $specs;

        // Process FAQs
        $faqs = [];
        $faqQs = $request->input('faq_qs', []);
        $faqAs = $request->input('faq_as', []);
        foreach ($faqQs as $idx => $q) {
            if (!empty($q) && isset($faqAs[$idx])) {
                $faqs[] = ['q' => $q, 'a' => $faqAs[$idx]];
            }
        }
        $v['faqs'] = $faqs;

        $service->update($v);
        Cache::forget('home_page_data');
        Cache::forget('services_page_data');
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $this->deleteStorageFile($service->image);
        $this->deleteStorageFile($service->brochure);
        $this->deleteStorageFile($service->og_image);
        if (is_array($service->gallery)) {
            foreach ($service->gallery as $img) {
                $this->deleteStorageFile($img);
            }
        }
        $service->delete();
        Cache::forget('home_page_data');
        Cache::forget('services_page_data');
        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
