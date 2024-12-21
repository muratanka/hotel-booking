<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'Türkçe',
                'locale' => 'tr',
                'language_code' => 'tr',
                'text_direction' => 'ltr',
                'flag' => 'images/flags/tr.png',
                'status' => true,
                'sort_order' => 1,
                'is_default' => true,
            ],
            [
                'name' => 'English',
                'locale' => 'en',
                'language_code' => 'en',
                'text_direction' => 'ltr',
                'flag' => 'images/flags/en.png',
                'status' => true,
                'sort_order' => 2,
                'is_default' => false,
            ],

        ];

        foreach ($languages as $language) {
            // Kayıt var mı kontrol et, yoksa ekle, varsa güncelle
            Language::updateOrCreate(
                ['locale' => $language['locale']], // Unique alan kontrolü
                $language // Mevcut kayıt varsa güncellenir
            );
        }
    }
}
