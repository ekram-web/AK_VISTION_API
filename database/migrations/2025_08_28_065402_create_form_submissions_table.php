<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'Sales', 'Technical', 'Subscription'
            $table->json('data');   // Flexible JSON column to store all form fields
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('form_submissions'); }
};
