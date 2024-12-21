<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\TranslationLoader\LanguageLine;


class LanguageLineSeeder extends Seeder
{
    public function run()
    {
        $translations = [
            [
                'group' => 'messages',
                'key' => 'welcome',
                'text' => [
                    'en' => 'Welcome',
                    'tr' => 'Hoşgeldiniz',
                ],
            ],
            [
                'group' => 'messages',
                'key' => 'goodbye',
                'text' => [
                    'en' => 'Goodbye',
                    'tr' => 'Güle Güle',
                ],
            ],
            [
                'group' => 'auth',
                'key' => 'login',
                'text' => [
                    'en' => 'Login',
                    'tr' => 'Giriş Yap',
                ],
            ],
        ];

        foreach ($translations as $translation) {
            LanguageLine::updateOrCreate(
                [
                    'group' => $translation['group'],
                    'key' => $translation['key'],
                ],
                [
                    'text' => $translation['text'],
                ]
            );
        }
    }
}
