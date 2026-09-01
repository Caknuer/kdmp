<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Settings Controller
 * 
 * Manages website settings and configuration.
 * Allows admin to update site information, contact details, and social media links.
 * 
 * @package App\Http\Controllers\Admin
 */
class AdminSettingController extends Controller
{
    /**
     * Show settings form
     * 
     * Displays all current settings for editing.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all settings and index them by key
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings in database
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string', 'max:500'],
            'site_keywords' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email'],
            'footer_description' => ['required', 'string'],
            'gmaps_url' => ['nullable', 'string'],
            'facebook' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'tiktok' => ['nullable', 'url'],
            'youtube' => ['nullable', 'url'],
            'whatsapp' => ['nullable', 'string'],
            'site_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'site_favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,ico', 'max:1024'],
            'hero_badge' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'hero_images' => ['nullable', 'array'],
            'hero_images.*' => ['image', 'mimes:png,jpg,jpeg', 'max:5120'],
            'remove_hero_images' => ['nullable', 'array'],
            'remove_hero_images.*' => ['string'],
        ], [
            'site_name.required' => 'Nama situs wajib diisi',
            'site_description.max' => 'Deskripsi maksimal 500 karakter',
            'site_keywords.max' => 'Keywords maksimal 255 karakter',
            'address.required' => 'Alamat wajib diisi',
            'phone.required' => 'Telepon wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'footer_description.required' => 'Deskripsi footer wajib diisi',
            'site_logo.image' => 'Logo harus berupa gambar',
            'site_logo.mimes' => 'Logo harus format PNG, JPG, JPEG, atau SVG',
            'site_logo.max' => 'Logo maksimal 2MB',
            'site_favicon.image' => 'Favicon harus berupa gambar',
            'site_favicon.mimes' => 'Favicon harus format PNG, JPG, JPEG, atau ICO',
            'site_favicon.max' => 'Favicon maksimal 1MB',
            'hero_badge.max' => 'Hero badge maksimal 255 karakter',
            'hero_title.max' => 'Hero title maksimal 255 karakter',
            'hero_subtitle.max' => 'Hero subtitle maksimal 255 karakter',
            'hero_description.max' => 'Hero description maksimal 1000 karakter',
            'hero_images.array' => 'Hero images harus berupa array',
            'hero_images.*.image' => 'Setiap hero image harus berupa gambar',
            'hero_images.*.mimes' => 'Hero images harus format PNG, JPG, atau JPEG',
            'hero_images.*.max' => 'Setiap hero image maksimal 5MB',
        ]);

        // Handle file uploads
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            $oldLogo = Setting::where('key', 'site_logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $validated['site_logo'] = $logoPath;
        }

        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            $oldFavicon = Setting::where('key', 'site_favicon')->value('value');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            $validated['site_favicon'] = $faviconPath;
        }

        // Handle hero images (multiple files)
        $currentHeroImages = [];
        $existingHeroImages = Setting::where('key', 'hero_images')->value('value');
        if ($existingHeroImages) {
            $currentHeroImages = is_array($existingHeroImages) ? $existingHeroImages : json_decode($existingHeroImages, true) ?? [];
        }

        // Remove images if requested
        if ($request->has('remove_hero_images')) {
            $imagesToRemove = $request->input('remove_hero_images', []);
            foreach ($imagesToRemove as $imageToRemove) {
                if (in_array($imageToRemove, $currentHeroImages)) {
                    if (Storage::disk('public')->exists($imageToRemove)) {
                        Storage::disk('public')->delete($imageToRemove);
                    }
                    $currentHeroImages = array_diff($currentHeroImages, [$imageToRemove]);
                }
            }
        }

        // Add new images
        if ($request->hasFile('hero_images')) {
            foreach ($request->file('hero_images') as $file) {
                $heroImagePath = $file->store('hero', 'public');
                $currentHeroImages[] = $heroImagePath;
            }
        }

        // Update hero_images if there are changes
        if (!empty($currentHeroImages) || $request->hasFile('hero_images') || $request->has('remove_hero_images')) {
            $validated['hero_images'] = json_encode(array_values($currentHeroImages));
        }

        // Update each setting
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            cache()->forget('setting_'.$key);
        }

        // Clear app-wide settings cache if present
        cache()->forget('settings');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }
}
