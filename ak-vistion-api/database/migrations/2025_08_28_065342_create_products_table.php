<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('main_category');
            $table->string('sub_category')->nullable();
            $table->string('use_case')->nullable();
            $table->integer('channels')->nullable();
            $table->integer('ports')->nullable();
            $table->string('application')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('buy_now_url')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
