
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
        public function up(): void {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->text('quote');
            $table->string('company');
            $table->string('logo_url')->nullable(); // <-- THIS IS THE CRITICAL ADDITION
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('testimonials'); }
};
