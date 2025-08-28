<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('homepage_data', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // e.g., 'hero', 'newsroom'
            $table->json('content');   // Store titles, text, URLs as JSON
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('homepage_data'); }
};
