<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('excerpt');
            $table->string('image_url')->nullable();
            $table->string('category')->nullable();
            $table->string('author')->nullable();
            $table->string('date')->nullable(); // Using string to match your frontend
            $table->string('read_time')->nullable();
            $table->longText('content')->nullable(); // For the full post later
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('blog_posts'); }
};
