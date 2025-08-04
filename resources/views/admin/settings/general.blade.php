@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<div class="text-black">

  <h1 class="text-3xl font-bold mb-6">General Settings</h1>

   @include('partials.flash-messages')

  {{-- Tabs --}}
  <div>
    <nav class="flex space-x-4 border-b border-zinc-700 mb-6" role="tablist" aria-label="General Settings Tabs">
      @php
        $tabs = [
          'site' => 'Site Info',
          'branding' => 'Branding',
          'security' => 'URL & Security',
          'localization' => 'Localization',
          'seo' => 'SEO & Metadata',
          'contact' => 'Contact Info',
        ];
        $activeTab = old('active_tab', 'site');
      @endphp

      @foreach($tabs as $key => $label)
        <button
          type="button"
          role="tab"
          aria-selected="{{ $activeTab === $key ? 'true' : 'false' }}"
          aria-controls="tab-panel-{{ $key }}"
          id="tab-{{ $key }}"
          class="py-2 px-4 -mb-px border-b-2 font-semibold
            {{ $activeTab === $key ? 'border-orange-600 text-orange-600' : 'border-transparent hover:text-orange-500' }}"
          onclick="switchTab('{{ $key }}')"
        >
          {{ $label }}
        </button>
      @endforeach
    </nav>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="settingsForm">
      @csrf
      <input type="hidden" name="active_tab" id="active_tab" value="{{ $activeTab }}">

      {{-- Site Info --}}
      <section
        id="tab-panel-site"
        role="tabpanel"
        aria-labelledby="tab-site"
        class="{{ $activeTab === 'site' ? '' : 'hidden' }}"
      >
        <h2 class="text-xl font-semibold mb-4">Site Title & Tagline</h2>

        <div class="mb-4">
          <label for="site_title" class="block font-medium mb-1">Site Title <span class="text-red-500">*</span></label>
          <input
            type="text"
            name="site_title"
            id="site_title"
            value="{{ old('site_title', $settings['site_title'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
            required
          >
          @error('site_title')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="site_tagline" class="block font-medium mb-1">Site Tagline</label>
          <input
            type="text"
            name="site_tagline"
            id="site_tagline"
            value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >
          @error('site_tagline')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>
      </section>

      {{-- Branding --}}
      <section
        id="tab-panel-branding"
        role="tabpanel"
        aria-labelledby="tab-branding"
        class="{{ $activeTab === 'branding' ? '' : 'hidden' }}"
      >
        <h2 class="text-xl font-semibold mb-4">Branding & Appearance</h2>

        <div class="mb-6">
          <label class="block font-medium mb-2">Current Site Logo</label>
          @if(!empty($settings['site_logo']))
            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Site Logo" class="h-20 mb-2 rounded border border-zinc-700">
          @else
            <p class="text-gray-400 italic">No logo uploaded yet.</p>
          @endif

          <label for="site_logo" class="block font-medium mt-4 mb-1">Upload New Site Logo (PNG, JPG, max 2MB)</label>
          <input
            type="file"
            name="site_logo"
            id="site_logo"
            accept="image/png, image/jpeg"
            class="block w-full text-sm file:mr-4 file:py-2 file:px-4
                   file:rounded file:border-0
                   file:text-sm file:font-semibold
                   file:bg-orange-600 file:text-white
                   hover:file:bg-orange-700"
            onchange="previewImage(event, 'logoPreview')"
          >
          @error('site_logo')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror

          <img id="logoPreview" src="#" alt="Logo Preview" class="mt-4 hidden h-20 rounded border border-zinc-700">
        </div>

        <div>
          <label class="block font-medium mb-2">Current Favicon</label>
          @if(!empty($settings['favicon']))
            <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon" class="h-10 w-10 mb-2 rounded border border-zinc-700">
          @else
            <p class="text-gray-400 italic">No favicon uploaded yet.</p>
          @endif

          <label for="favicon" class="block font-medium mt-4 mb-1">Upload New Favicon (ICO, PNG, JPG, max 1MB)</label>
          <input
            type="file"
            name="favicon"
            id="favicon"
            accept=".ico,image/png,image/jpeg"
            class="block w-full text-sm file:mr-4 file:py-2 file:px-4
                   file:rounded file:border-0
                   file:text-sm file:font-semibold
                   file:bg-orange-600 file:text-white
                   hover:file:bg-orange-700"
            onchange="previewImage(event, 'faviconPreview')"
          >
          @error('favicon')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror

          <img id="faviconPreview" src="#" alt="Favicon Preview" class="mt-4 hidden h-10 w-10 rounded border border-zinc-700">
        </div>
      </section>

      {{-- URL & Security --}}
      <section
        id="tab-panel-security"
        role="tabpanel"
        aria-labelledby="tab-security"
        class="{{ $activeTab === 'security' ? '' : 'hidden' }}"
      >
        <h2 class="text-xl font-semibold mb-4">URL & Security</h2>

        <div class="mb-4">
          <label for="site_url" class="block font-medium mb-1">Site URL <span class="text-red-500">*</span></label>
          <input
            type="url"
            name="site_url"
            id="site_url"
            value="{{ old('site_url', $settings['site_url'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
            required
          >
          @error('site_url')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center space-x-3">
          <input
            type="checkbox"
            name="force_https"
            id="force_https"
            value="1"
            {{ old('force_https', $settings['force_https'] ?? false) ? 'checked' : '' }}
            class="w-5 h-5 text-orange-600  border-zinc-700 rounded"
          >
          <label for="force_https" class="font-medium">Force HTTPS Redirect</label>
        </div>
      </section>

      {{-- Localization --}}
      <section
        id="tab-panel-localization"
        role="tabpanel"
        aria-labelledby="tab-localization"
        class="{{ $activeTab === 'localization' ? '' : 'hidden' }}"
      >
        <h2 class="text-xl font-semibold mb-4">Localization & User Registration</h2>

        <div class="mb-4">
          <label for="default_language" class="block font-medium mb-1">Default Language <span class="text-red-500">*</span></label>
          <input
            type="text"
            name="default_language"
            id="default_language"
            value="{{ old('default_language', $settings['default_language'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
            required
          >
          <small class="text-gray-400">Use language codes (e.g. en, es, fr)</small>
          @error('default_language')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
          <label for="available_languages" class="block font-medium mb-1">Available Languages</label>
          <textarea
            name="available_languages"
            id="available_languages"
            rows="3"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >{{ old('available_languages', $settings['available_languages'] ?? '["en"]') }}</textarea>
          <small class="text-gray-400">JSON list e.g. ["en", "es", "fr"]</small>
          @error('available_languages')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center space-x-3 mb-4">
          <input
            type="checkbox"
            name="allow_user_registration"
            id="allow_user_registration"
            value="1"
            {{ old('allow_user_registration', $settings['allow_user_registration'] ?? false) ? 'checked' : '' }}
            class="w-5 h-5 text-orange-600  border-zinc-700 rounded"
          >
          <label for="allow_user_registration" class="font-medium">Allow User Registration</label>
        </div>

        <div class="flex items-center space-x-3">
          <input
            type="checkbox"
            name="enable_email_verification"
            id="enable_email_verification"
            value="1"
            {{ old('enable_email_verification', $settings['enable_email_verification'] ?? false) ? 'checked' : '' }}
            class="w-5 h-5 text-orange-600  border-zinc-700 rounded"
          >
          <label for="enable_email_verification" class="font-medium">Enable Email Verification</label>
        </div>
      </section>

      {{-- SEO & Metadata --}}
      <section
        id="tab-panel-seo"
        role="tabpanel"
        aria-labelledby="tab-seo"
        class="{{ $activeTab === 'seo' ? '' : 'hidden' }}"
      >
        <h2 class="text-xl font-semibold mb-4">SEO & Metadata</h2>

        <div class="mb-4">
          <label for="meta_title_default" class="block font-medium mb-1">Default Meta Title</label>
          <input
            type="text"
            name="meta_title_default"
            id="meta_title_default"
            value="{{ old('meta_title_default', $settings['meta_title_default'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >
          @error('meta_title_default')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
          <label for="meta_keywords" class="block font-medium mb-1">Default Meta Keywords</label>
          <input
            type="text"
            name="meta_keywords"
            id="meta_keywords"
            value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >
          <small class="text-gray-400">Comma-separated keywords (e.g. music, beats, audio)</small>
          @error('meta_keywords')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
          <label for="meta_description_default" class="block font-medium mb-1">Default Meta Description</label>
          <textarea
            name="meta_description_default"
            id="meta_description_default"
            rows="3"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >{{ old('meta_description_default', $settings['meta_description_default'] ?? '') }}</textarea>
          @error('meta_description_default')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
          <label for="google_site_verification" class="block font-medium mb-1">Google Site Verification</label>
          <input
            type="text"
            name="google_site_verification"
            id="google_site_verification"
            value="{{ old('google_site_verification', $settings['google_site_verification'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >
          @error('google_site_verification')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>
      </section>

      {{-- Contact Info --}}
      <section
        id="tab-panel-contact"
        role="tabpanel"
        aria-labelledby="tab-contact"
        class="{{ $activeTab === 'contact' ? '' : 'hidden' }}"
      >
        <h2 class="text-xl font-semibold mb-4">Contact Information</h2>

        <div class="mb-4">
          <label for="contact_email" class="block font-medium mb-1">Contact Email</label>
          <input
            type="email"
            name="contact_email"
            id="contact_email"
            value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >
          @error('contact_email')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
          <label for="contact_phone" class="block font-medium mb-1">Contact Phone</label>
          <input
            type="text"
            name="contact_phone"
            id="contact_phone"
            value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >
          @error('contact_phone')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="contact_address" class="block font-medium mb-1">Contact Address</label>
          <textarea
            name="contact_address"
            id="contact_address"
            rows="3"
            class="w-full px-4 py-2 rounded  border border-zinc-700 focus:border-orange-600 focus:outline-none"
          >{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
          @error('contact_address')<p class="text-red-500 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>
      </section>

      <div class="pt-6 border-t border-zinc-700 flex justify-end">
        <button
          type="submit"
          class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-6 rounded transition"
        >
          Save Changes
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Tab JS --}}
<script>
  function switchTab(tabKey) {
    // Hide all tab panels
    document.querySelectorAll('[role="tabpanel"]').forEach(panel => panel.classList.add('hidden'));
    // Remove active styling from tabs
    document.querySelectorAll('[role="tab"]').forEach(tab => {
      tab.setAttribute('aria-selected', 'false');
      tab.classList.remove('border-orange-600', 'text-orange-600');
      tab.classList.add('border-transparent', 'hover:text-orange-500');
    });

    // Show selected tab panel
    document.getElementById('tab-panel-' + tabKey).classList.remove('hidden');
    // Mark tab active
    const activeTab = document.getElementById('tab-' + tabKey);
    activeTab.setAttribute('aria-selected', 'true');
    activeTab.classList.add('border-orange-600', 'text-orange-600');
    activeTab.classList.remove('border-transparent', 'hover:text-orange-500');

    // Update hidden input
    document.getElementById('active_tab').value = tabKey;
  }

  // Image preview function
  function previewImage(event, previewId) {
    const input = event.target;
    const preview = document.getElementById(previewId);
    if(input.files && input.files[0]){
      preview.src = URL.createObjectURL(input.files[0]);
      preview.classList.remove('hidden');
    }
  }
</script>
@endsection
