<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_page_data', function (Blueprint $table) {
            $table->id();
            $table->string('category_key')->unique(); // "cameras", "recorders", etc.
            $table->string('title');
            $table->text('intro_text');
            $table->string('hero_image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_page_data');
    }
};
