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
        Schema::create('seo_models', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->json('keywords')->nullable();
            $table->string('conical_url')->nullable();

            $table->enum('indexable',['index','noindex'])->default('index');
            $table->enum('followable',['follow','nofollow'])->default('follow');

            $table->string('seo_type')->default('WebPage');
            $table->json('schema')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_models');
    }
};
