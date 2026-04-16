<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\DomainMailAnalytic;
use App\Models\Mailbox;
use App\Models\MailboxMailAnalytic;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class MailAnalyticsService
{
    public function getClientSummary(int $clientId): array
    {
        $domainIds = Domain::where('client_id', $clientId)->pluck('id');
        $mailboxIds = Mailbox::where('client_id', $clientId)->pluck('id');

        $domainStats = DomainMailAnalytic::whereIn('domain_id', $domainIds)->selectRaw(
            'COALESCE(SUM(sent_count),0) as sent, COALESCE(SUM(received_count),0) as received'
        )->first();

        $mailboxStats = MailboxMailAnalytic::whereIn('mailbox_id', $mailboxIds)->selectRaw(
            'COALESCE(SUM(sent_count),0) as sent, COALESCE(SUM(received_count),0) as received'
        )->first();

        return [
            'domains_sent_total' => (int) ($domainStats->sent ?? 0),
            'domains_received_total' => (int) ($domainStats->received ?? 0),
            'mailboxes_sent_total' => (int) ($mailboxStats->sent ?? 0),
            'mailboxes_received_total' => (int) ($mailboxStats->received ?? 0),
        ];
    }

    public function getDomainBreakdown(Collection $domainIds): Collection
    {
        if ($domainIds->isEmpty()) {
            return collect();
        }

        return DomainMailAnalytic::query()
            ->whereIn('domain_id', $domainIds)
            ->selectRaw('domain_id, COALESCE(SUM(sent_count),0) as sent_total, COALESCE(SUM(received_count),0) as received_total')
            ->groupBy('domain_id')
            ->get()
            ->keyBy('domain_id');
    }

    public function recordDomainSent(int $domainId, int $count = 1, ?Carbon $date = null): void
    {
        $this->upsertDomainMetric($domainId, 'sent_count', $count, $date);
    }

    public function recordDomainReceived(int $domainId, int $count = 1, ?Carbon $date = null): void
    {
        $this->upsertDomainMetric($domainId, 'received_count', $count, $date);
    }

    public function recordMailboxSent(int $mailboxId, int $count = 1, ?Carbon $date = null): void
    {
        $this->upsertMailboxMetric($mailboxId, 'sent_count', $count, $date);
    }

    public function recordMailboxReceived(int $mailboxId, int $count = 1, ?Carbon $date = null): void
    {
        $this->upsertMailboxMetric($mailboxId, 'received_count', $count, $date);
    }

    private function upsertDomainMetric(int $domainId, string $column, int $count, ?Carbon $date): void
    {
        $metricDate = ($date ?? now())->toDateString();

        $row = DomainMailAnalytic::firstOrCreate([
            'domain_id' => $domainId,
            'metric_date' => $metricDate,
        ]);

        $row->{$column} += $count;
        $row->save();
    }

    private function upsertMailboxMetric(int $mailboxId, string $column, int $count, ?Carbon $date): void
    {
        $metricDate = ($date ?? now())->toDateString();

        $row = MailboxMailAnalytic::firstOrCreate([
            'mailbox_id' => $mailboxId,
            'metric_date' => $metricDate,
        ]);

        $row->{$column} += $count;
        $row->save();
    }
}

