<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\MailAnalyticsCursor;
use App\Models\Mailbox;
use Illuminate\Support\Str;

class MailLogAnalyticsIngestionService
{
    public function __construct(private readonly MailAnalyticsService $analyticsService)
    {
    }

    public function ingest(string $filePath, string $sourceKey = 'mail_log_main'): array
    {
        if (!is_readable($filePath)) {
            return ['processed' => 0, 'sent' => 0, 'received' => 0, 'status' => 'unreadable'];
        }

        $cursor = MailAnalyticsCursor::firstOrCreate(
            ['source_key' => $sourceKey],
            ['file_path' => $filePath, 'last_position' => 0]
        );

        $fingerprint = $this->fingerprint($filePath);
        if ($cursor->file_fingerprint && $cursor->file_fingerprint !== $fingerprint) {
            $cursor->last_position = 0;
        }

        $handle = fopen($filePath, 'rb');
        if ($handle === false) {
            return ['processed' => 0, 'sent' => 0, 'received' => 0, 'status' => 'open_failed'];
        }

        fseek($handle, (int) $cursor->last_position);

        $processed = 0;
        $sent = 0;
        $received = 0;

        while (($line = fgets($handle)) !== false) {
            $processed++;
            $result = $this->parseLine($line);
            if ($result === null) {
                continue;
            }

            if ($result['direction'] === 'sent') {
                $sent++;
                $this->recordSent($result['email']);
            } else {
                $received++;
                $this->recordReceived($result['email']);
            }
        }

        $cursor->file_path = $filePath;
        $cursor->last_position = ftell($handle) ?: $cursor->last_position;
        $cursor->file_fingerprint = $fingerprint;
        $cursor->last_processed_at = now();
        $cursor->save();

        fclose($handle);

        return [
            'processed' => $processed,
            'sent' => $sent,
            'received' => $received,
            'status' => 'ok',
        ];
    }

    private function parseLine(string $line): ?array
    {
        if (!str_contains($line, 'status=sent')) {
            return null;
        }

        if (!preg_match('/to=<([^>]+)>/i', $line, $toMatch)) {
            return null;
        }

        $email = Str::lower(trim($toMatch[1]));
        if (!str_contains($email, '@')) {
            return null;
        }

        $direction = str_contains($line, 'postfix/smtp') ? 'sent' : (str_contains($line, 'postfix/lmtp') ? 'received' : null);
        if ($direction === null) {
            return null;
        }

        return ['email' => $email, 'direction' => $direction];
    }

    private function recordSent(string $email): void
    {
        $mailbox = Mailbox::where('email', $email)->first();
        if (!$mailbox) {
            return;
        }

        $this->analyticsService->recordMailboxSent($mailbox->id);
        $this->analyticsService->recordDomainSent($mailbox->domain_id);
    }

    private function recordReceived(string $email): void
    {
        $mailbox = Mailbox::where('email', $email)->first();
        if ($mailbox) {
            $this->analyticsService->recordMailboxReceived($mailbox->id);
            $this->analyticsService->recordDomainReceived($mailbox->domain_id);
            return;
        }

        $domainPart = Str::after($email, '@');
        $domain = Domain::where('domain', $domainPart)->first();
        if ($domain) {
            $this->analyticsService->recordDomainReceived($domain->id);
        }
    }

    private function fingerprint(string $filePath): ?string
    {
        $inode = @fileinode($filePath);
        $size = @filesize($filePath);
        $mtime = @filemtime($filePath);
        if ($inode === false || $size === false || $mtime === false) {
            return null;
        }

        return implode(':', [$inode, $size, $mtime]);
    }
}

