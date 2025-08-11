<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Menü adı
            $table->string('slug')->unique();    // URL dostu ad
            $table->time('start_time');          // Başlangıç saati
            $table->time('end_time');            // Bitiş saati
            $table->text('description')->nullable(); // Opsiyonel açıklama
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
