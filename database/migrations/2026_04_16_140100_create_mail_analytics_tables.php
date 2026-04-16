<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('domain_mail_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained()->cascadeOnDelete();
            $table->date('metric_date');
            $table->unsignedBigInteger('sent_count')->default(0);
            $table->unsignedBigInteger('received_count')->default(0);
            $table->timestamps();
            $table->unique(['domain_id', 'metric_date']);
        });

        Schema::create('mailbox_mail_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mailbox_id')->constrained()->cascadeOnDelete();
            $table->date('metric_date');
            $table->unsignedBigInteger('sent_count')->default(0);
            $table->unsignedBigInteger('received_count')->default(0);
            $table->timestamps();
            $table->unique(['mailbox_id', 'metric_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mailbox_mail_analytics');
        Schema::dropIfExists('domain_mail_analytics');
    }
};

