<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use App\Services\MailLogAnalyticsIngestionService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('analytics:ingest-mail-logs {--file=} {--source=mail_log_main}', function () {
    $filePath = $this->option('file') ?: env('MAIL_ANALYTICS_LOG_PATH', '/var/log/mail.log');
    $sourceKey = (string) $this->option('source');

    /** @var MailLogAnalyticsIngestionService $service */
    $service = app(MailLogAnalyticsIngestionService::class);
    $result = $service->ingest($filePath, $sourceKey);

    $this->info('Mail analytics ingestion: '.json_encode($result));
})->purpose('Ingest mail log stats into analytics tables');

Schedule::command('analytics:ingest-mail-logs')
    ->everyFiveMinutes()
    ->when(fn () => env('MAIL_ANALYTICS_ENABLED', true))
    ->onFailure(function () {
        Log::error('analytics:ingest-mail-logs scheduler run failed');
    });
