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
        Schema::create('questionnaire_forms', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('body')->nullable();
            $table->string('template')->nullable();
            $table->boolean('has_file')->default(false);
            $table->boolean('response_client')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_forms');
    }
};
