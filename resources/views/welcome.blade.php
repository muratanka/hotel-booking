<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Test</title>
</head>
<body>
    <h1>{{ __('messages.welcome') }}</h1>
    <p>Current Locale: {{ App::getLocale() }}</p>

    <h2>Available Languages:</h2>
    @php
    $languages = \App\Models\Language::activeLanguages();
    $currentLocale = App::getLocale();
    $defaultLocale = \App\Models\Language::default()->locale;
@endphp

<ul>
    @foreach ($languages as $language)
        @if ($language->locale !== $currentLocale)
            @if ($language->locale === $defaultLocale)
                <!-- Varsayılan dil için bağlantı -->
                <li>
                    <a href="{{ url('/') }}">
                        <img src="{{ asset($language->flag) }}" alt="{{ $language->name }}" width="20">
                        {{ $language->name }}
                    </a>
                </li>
            @else
                <!-- Diğer diller için bağlantı -->
                <li>
                    <a href="{{ url($language->locale) }}">
                        <img src="{{ asset($language->flag) }}" alt="{{ $language->name }}" width="20">
                        {{ $language->name }}
                    </a>
                </li>
            @endif
        @else
            <!-- Mevcut dil -->
            <li>{{ $language->name }} (Current)</li>
        @endif
    @endforeach
</ul>

</body>
</html>
