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
        Schema::create('footer_contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // "Address", "Phone", "Email", "Hours"
            $table->text('value');  // The actual text content
            $table->string('icon')->nullable(); // Optional: For an icon name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_contact_details');
    }
};
