<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->text('instructions')->nullable();
            $table->json('pdf_links')->nullable(); // To store an array of PDF paths
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('guides'); }
};
