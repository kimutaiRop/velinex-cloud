<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mail_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('price_kes')->default(0);   // monthly price in KES
            $table->unsignedInteger('storage_mb');               // per-mailbox quota
            $table->unsignedSmallInteger('max_domains')->nullable(); // null = unlimited
            $table->json('features');                            // array of feature strings shown on pricing card
            $table->boolean('is_featured')->default(false);     // highlighted / "popular" badge
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_plans');
    }
};
