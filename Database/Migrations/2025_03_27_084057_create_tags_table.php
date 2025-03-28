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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->timestamps();
        });
        Schema::create('tag_models', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->morphs('model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_models');
        Schema::dropIfExists('tags');
    }
};
