<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        // Eğer tablo zaten mevcutsa tekrar oluşturulmaz
        if (!Schema::hasTable('languages')) {
            Schema::create('languages', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique()->nullable(false); // Dil adı
                $table->string('locale')->unique()->nullable(false); // Laravel locale
                $table->string('language_code', 2)->unique()->nullable(false); // ISO 639-1
                $table->enum('text_direction', ['ltr', 'rtl'])->default('ltr'); // Metin yönü
                $table->string('flag')->nullable(false); // Bayrak görsel yolu
                $table->boolean('status')->default(true); // Aktif mi?
                $table->integer('sort_order')->default(0); // Sıralama önceliği
                $table->boolean('is_default')->default(false); // Varsayılan dil mi?
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
