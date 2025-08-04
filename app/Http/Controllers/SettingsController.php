<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Setting;

class SettingsController extends Controller
{

    public function general()
    {
        $siteTitle = Setting::getValue('site_title', 'Default Site Title');
        // Load all needed settings
        $settings = [
            'site_title' => Setting::getValue('site_title', 'BeatWave'),
            'site_tagline' => Setting::getValue('site_tagline', 'Your music, your vibe'),
            'site_logo' => Setting::getValue('site_logo', ''),
            'favicon' => Setting::getValue('favicon', ''),
            'site_url' => Setting::getValue('site_url', 'https://www.beatwave.com'),
            'force_https' => Setting::getValue('force_https', '1'),
            'default_language' => Setting::getValue('default_language', 'en'),
            'available_languages' => Setting::getValue('available_languages', json_encode(['en', 'es', 'fr'])),
            'allow_user_registration' => Setting::getValue('allow_user_registration', '1'),
            'enable_email_verification' => Setting::getValue('enable_email_verification', '1'),
            'meta_title_default' => Setting::getValue('meta_title_default', ''),
            'meta_keywords_default' => Setting::getValue('meta_keywords_default', ''),
            'meta_description_default' => Setting::getValue('meta_description_default', ''),
            'google_site_verification' => Setting::getValue('google_site_verification', ''),
            'robots_txt' => Setting::getValue('robots_txt', "User-agent: *\nDisallow: /admin/\nAllow: /"),
            'contact_email' => Setting::getValue('contact_email', ''),
            'contact_phone' => Setting::getValue('contact_phone', ''),
        ];

        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,ico|max:1024',
            'site_url' => 'required|url|max:255',
            'force_https' => 'required|boolean',
            'default_language' => 'required|string|max:10',
            'available_languages' => 'required|string', // JSON string
            'allow_user_registration' => 'required|boolean',
            'enable_email_verification' => 'required|boolean',
            'meta_title_default' => 'nullable|string|max:255',
            'meta_description_default' => 'nullable|string|max:500',
            'meta_keywords_default' => 'nullable|string|max:255',
            'google_site_verification' => 'nullable|string|max:255',
            'robots_txt' => 'nullable|string',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:30',
        ]);
        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('uploads/site', 'public');
            Setting::setValue('site_logo', $logoPath);
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('uploads/favicon', 'public');
            Setting::setValue('favicon', $faviconPath);
        }

        // Save all other settings
        foreach ($validated as $key => $value) {
            if (!in_array($key, ['site_logo', 'favicon'])) {
                Setting::setValue($key, $value);
            }
            Cache::forget('global_site_settings');
        }

        return redirect()->route('admin.settings.general')->with('success', 'General settings updated successfully.');
    }
}
