<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Language;
use Illuminate\Support\Facades\Log;

class SetLocale
{
  public function handle($request, Closure $next)
  {
    $locale = $request->segment(1); // URL'deki dil kodunu al
    $defaultLanguage = Language::default(); // Veritabanındaki varsayılan dil
    Log::info('Default Language: ' . $defaultLanguage->locale);
    $activeLanguages = Language::activeLanguages()->pluck('locale')->toArray(); // Aktif diller
    Log::info('Active Languages: ' . implode(', ', $activeLanguages));
    $sessionLocale = Session::get('locale'); // Oturumdaki dil
    Log::info('Session Locale Before: ' . $sessionLocale);

    // Veritabanı ile oturumdaki dil uyumsuz ise senkronize et
    if ($sessionLocale !== $defaultLanguage->locale) {
      Session::put('locale', $defaultLanguage->locale);
      Log::info('Session Locale Updated to Default: ' . $defaultLanguage->locale);
    }

    if (in_array($locale, $activeLanguages)) {
      App::setLocale($locale);
      Session::put('locale', $locale);
      Log::info('Session Locale Updated to URL Locale: ' . $locale);
    } elseif ($sessionLocale) {
      App::setLocale($sessionLocale);
      Log::info('App Locale Set to Session Locale: ' . $sessionLocale);
    } else {
      App::setLocale($defaultLanguage->locale);
      Session::put('locale', $defaultLanguage->locale);
      Log::info('App Locale Set to Default Locale: ' . $defaultLanguage->locale);
    }

    Log::info('Final Session Locale: ' . Session::get('locale'));
    return $next($request);
  }
}
