<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     public function up(): void {
        Schema::create('homepage_data', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique(); // <-- Make sure this is unique
            $table->json('content');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('homepage_data'); }
};
