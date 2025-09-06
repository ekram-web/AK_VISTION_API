<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('support_files', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'Firmware', 'SDK', 'Software'
            $table->string('name');
            $table->string('product_model')->nullable();
            $table->string('version')->nullable();
            $table->string('size')->nullable();
            $table->date('release_date')->nullable();
            $table->text('description')->nullable();
            $table->string('file_url')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('support_files'); }
};
