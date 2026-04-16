<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mail_analytics_cursors', function (Blueprint $table) {
            $table->id();
            $table->string('source_key')->unique();
            $table->string('file_path');
            $table->unsignedBigInteger('last_position')->default(0);
            $table->string('file_fingerprint', 120)->nullable();
            $table->timestamp('last_processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_analytics_cursors');
    }
};

