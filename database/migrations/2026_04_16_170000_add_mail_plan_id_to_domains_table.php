<?php

use App\Models\MailPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->foreignId('mail_plan_id')->nullable()->after('client_id')->constrained('mail_plans')->nullOnDelete();
        });

        $fallbackPlanId = MailPlan::query()->where('slug', 'business')->value('id')
            ?? MailPlan::query()->where('is_active', true)->orderBy('sort_order')->value('id');

        if ($fallbackPlanId) {
            \DB::table('domains')->whereNull('mail_plan_id')->update(['mail_plan_id' => $fallbackPlanId]);
        }
    }

    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropConstrainedForeignId('mail_plan_id');
        });
    }
};
