<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use App\Models\Language;

class RedirectDefaultLocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1); // İlk segment
        $defaultLanguage = Language::default(); // Varsayılan dil

        $activeLanguages = Language::activeLanguages()->pluck('locale')->toArray(); // Aktif diller

        Log::info("Segment 1 (Locale): {$locale}");
        Log::info("Supported Locales from Database: " . implode(', ', $activeLanguages));

        // Eğer URL dil kodu içeriyorsa ve bu dil varsayılan dilse, dil kodunu kaldırarak yönlendir.
        if (in_array($locale, $activeLanguages) && $locale === $defaultLanguage->locale) {
            $pathWithoutLocale = $request->path(); // Dil kodunu kaldır
            $pathWithoutLocale = preg_replace('/^' . preg_quote($locale, '/') . '\//', '', $pathWithoutLocale);
            return redirect($pathWithoutLocale);
        }

        // Eğer URL'de dil kodu yoksa varsayılan dili ayarla
        if (!in_array($locale, $activeLanguages)) {
            app()->setLocale($defaultLanguage->locale);
            Log::info("App Locale Set to Default Locale: {$defaultLanguage->locale}");
        }

        return $next($request);
    }
}
