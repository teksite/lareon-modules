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
        Schema::create('restrict_ips', function (Blueprint $table) {
            $table->id();
            $table->ipAddress();
            $table->string('type',12);
            $table->timestamps();
            $table->index(['ip_address' ,'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restrict_ips');
    }
};
