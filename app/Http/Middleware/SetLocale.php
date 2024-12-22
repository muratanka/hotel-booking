<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SetLocale
{
  public function handle($request, Closure $next)
  {
    // Aktif diller ve varsayılan dil
    $activeLanguages = Language::activeLanguages()->pluck('locale')->toArray();
    $defaultLanguage = Language::default();

    Log::info('Default Language: ' . $defaultLanguage->locale);
    Log::info('Active Languages: ' . implode(', ', $activeLanguages));

    // Dinamik olarak Laravel config ayarlarını güncelle
    Config::set('app.supported_locales', $activeLanguages);
    Config::set('app.locale', $defaultLanguage->locale);
    Config::set('app.fallback_locale', $defaultLanguage->locale);

    // URL'deki dil kodunu kontrol et
    $locale = $request->segment(1);
    Log::info('URL Locale: ' . $locale);

    if (in_array($locale, $activeLanguages)) {
      App::setLocale($locale);
      Session::put('locale', $locale);
      Log::info('Session Locale Updated to URL Locale: ' . $locale);
    } else {
      App::setLocale($defaultLanguage->locale);
      Session::put('locale', $defaultLanguage->locale);
      Log::info('App Locale Set to Default Locale: ' . $defaultLanguage->locale);
    }

    return $next($request);
  }
}
