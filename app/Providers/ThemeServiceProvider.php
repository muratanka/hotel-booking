<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;



class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Log::info('ThemeServiceProvider register() çalıştı.');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Log::info('ThemeServiceProvider boot() çalıştı.');


        Log::info('View yolları ayarlanıyor...');
        $this->configureThemes();
    }
    protected function configureThemes()
    {
        Log::info('Current View Paths Kontrolü: ' . implode(', ', app('view.finder')->getPaths()));
        $context = $this->getContext(); // admin veya frontend
        Log::info("Current Context: {$context}");
        $currentTheme = config("themes.current.{$context}", 'default');
        $themePath = resource_path("views/{$context}/{$currentTheme}");
        $defaultPath = resource_path("views/{$context}/default");

        Log::info("Configured Theme Path: {$themePath}");
        Log::info("Configured Default Path: {$defaultPath}");

        // Forward slash düzeltmeleri
        $themePath = str_replace('\\', '/', $themePath);
        $defaultPath = str_replace('\\', '/', $defaultPath);

        Log::info("Theme Path: {$themePath}");
        Log::info("Default Path: {$defaultPath}");

        if (is_dir($themePath)) {
            View::addLocation($themePath);
            Log::info("Theme Path eklendi: {$themePath}");
        } else {
            Log::warning("Theme Path bulunamadı: {$themePath}");
        }

        if (is_dir($defaultPath)) {
            View::addLocation($defaultPath);
            Log::info("Default Path eklendi: {$defaultPath}");
        } else {
            Log::warning("Default Path bulunamadı: {$defaultPath}");
        }
        $finder = app('view.finder');
        Log::info('Current View Paths Kontrolü: ' . implode(', ', $finder->getPaths()));
    }

    protected function getContext()
    {
        // Mevcut URL'yi loglamak
        Log::info('Current URL: ' . request()->url());

        // İlk segment dil kodunu temsil eder (ör: tr, en)
        $locale = request()->segment(1);
        Log::info("Segment 1 (Locale): {$locale}");
        Log::info("Segment 2: " . request()->segment(2));

        // Veritabanından aktif dilleri çek
        $supportedLocales = DB::table('languages')
            ->where('status', true)
            ->pluck('locale')
            ->toArray();

        Log::info('Supported Locales from Database: ' . implode(', ', $supportedLocales));

        // Eğer dil kodu mevcutsa, ikinci segment'e bak (admin mi kontrol etmek için)
        if (in_array($locale, $supportedLocales)) {
            return request()->segment(2) === 'admin' ? 'admin' : 'frontend';
        }

        // Eğer dil kodu yoksa, birinci segment'e bak
        return request()->segment(1) === 'admin' ? 'admin' : 'frontend';
    }
}
