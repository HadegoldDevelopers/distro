<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings globally with all views
        View::composer('*', function ($view) {
            $global = cache()->remember('global_site_settings', 60, function () {
                return [
                    'site_title' => Setting::getValue('site_title', 'BeatWave'),
                    'site_tagline' => Setting::getValue('site_tagline', 'Your music, your vibe'),
                    'site_logo' => Setting::getValue('site_logo', ''),
                    'favicon' => Setting::getValue('favicon', ''),
                    'meta_title' => Setting::getValue('meta_title_default', ''),
                    'meta_keywords' => Setting::getValue('meta_keywords_default', ''),
                    'meta_description' => Setting::getValue('meta_description_default', ''),
                ];
            });

            $view->with('global', $global);
        });
    }
}
