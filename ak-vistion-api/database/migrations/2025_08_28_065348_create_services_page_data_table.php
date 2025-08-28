<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('services_page_data', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // e.g., 'header', 'installation'
            $table->json('content');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('services_page_data'); }
};
