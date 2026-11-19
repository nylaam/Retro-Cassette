<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cassette_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('artist');
            $table->unsignedInteger('duration_sec')->default(0);
            $table->string('source_type', 20)->default('youtube');
            $table->string('source_id');
            $table->string('side', 1)->default('A');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->index(['cassette_id', 'side', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
