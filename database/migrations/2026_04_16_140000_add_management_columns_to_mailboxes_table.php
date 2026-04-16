<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mailboxes', function (Blueprint $table) {
            $table->string('password_mode', 40)->default('manual')->after('quota_mb');
            $table->string('secondary_email')->nullable()->after('password_mode');
            $table->boolean('require_initial_reset')->default(false)->after('secondary_email');
            $table->timestamp('password_shared_at')->nullable()->after('require_initial_reset');
            $table->timestamp('last_password_reset_at')->nullable()->after('password_shared_at');
            $table->string('password_delivery_status', 60)->nullable()->after('last_password_reset_at');
        });
    }

    public function down(): void
    {
        Schema::table('mailboxes', function (Blueprint $table) {
            $table->dropColumn([
                'password_mode',
                'secondary_email',
                'require_initial_reset',
                'password_shared_at',
                'last_password_reset_at',
                'password_delivery_status',
            ]);
        });
    }
};

