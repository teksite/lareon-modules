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
        Schema::create('questionnaire_inboxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->nullable()->constrained('questionnaire_forms')->nullOnDelete()->cascadeOnUpdate();
            $table->json('data');
            $table->string('url')->nullable();
            $table->json('note')->nullable();
            $table->ipAddress();
            $table->timestamp('read_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_inboxes');
    }
};
