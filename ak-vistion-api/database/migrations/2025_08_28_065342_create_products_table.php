<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('main_category'); // "Cameras", "Recorders", "Switches", or "Systems"
            $table->string('sub_category')->nullable();
            $table->string('use_case')->nullable(); // Specific to Cameras
            $table->integer('channels')->nullable(); // Specific to Recorders
            $table->integer('ports')->nullable(); // Specific to Switches
            $table->string('application')->nullable(); // Specific to Systems
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('buy_now_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
