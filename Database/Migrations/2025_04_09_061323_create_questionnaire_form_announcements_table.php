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
        Schema::create('questionnaire_form_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('questionnaire_forms')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('emails')->nullable();
            $table->text('phones')->nullable();
            $table->string('telegram_ids')->nullable();
            $table->text('urls')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_form_announcements');
    }
};
