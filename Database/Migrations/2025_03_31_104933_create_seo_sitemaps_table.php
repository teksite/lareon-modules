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
        Schema::create('seo_sitemaps', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('group', 50)->default('pages');
            $table->string('url');
            $table->decimal('priority', 3, 1)->default(0.5);
            $table->enum('changefreq', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])->default('monthly');
            $table->timestamp('lastmod')->nullable();
            $table->text('image')->nullable();
            $table->timestamp('active')->nullable()->default(now());
            $table->timestamps();

            $table->index(['group' , 'active']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_sitemaps');
    }
};
