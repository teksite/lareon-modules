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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('template',50)->nullable();
            $table->string('publish_status')->default('published');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_category_post', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('blog_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('blog_posts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(['category_id','post_id']);
        });

        Schema::create('blog_post_important', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('blog_posts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('hierarchy', 8, 2)->default(1.00);
            $table->unique('post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_important');
        Schema::dropIfExists('blog_category_post');
        Schema::dropIfExists('blog_posts');
    }
};
