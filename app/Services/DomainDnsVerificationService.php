<?php

namespace App\Services;

use App\Models\Domain;

class DomainDnsVerificationService
{
    public function verify(Domain $domain): array
    {
        $results = [];
        $allRequiredValid = true;

        foreach ($domain->dnsRecords as $record) {
            $valid = $this->recordExists($record->type, $record->host, $record->value, $record->priority);

            $results[] = [
                'type' => $record->type,
                'host' => $record->host,
                'expected' => $record->value,
                'priority' => $record->priority,
                'valid' => $valid,
            ];

            if ($record->is_required && !$valid) {
                $allRequiredValid = false;
            }
        }

        $domain->status = $allRequiredValid ? 'verified' : 'pending';
        $domain->verified_at = $allRequiredValid ? now() : null;
        $domain->save();

        return [
            'all_valid' => $allRequiredValid,
            'records' => $results,
        ];
    }

    private function recordExists(string $type, string $host, string $expectedValue, ?int $priority = null): bool
    {
        $records = @dns_get_record($host, $this->toDnsType($type));

        if ($records === false || $records === []) {
            return false;
        }

        foreach ($records as $record) {
            if ($type === 'TXT') {
                $txtValue = $record['txt'] ?? ($record['entries'][0] ?? null);
                if ($txtValue !== null && trim($txtValue) === trim($expectedValue)) {
                    return true;
                }
            }

            if ($type === 'MX') {
                $target = $record['target'] ?? null;
                $mxPriority = $record['pri'] ?? null;
                $targetMatches = $target !== null && rtrim($target, '.') === rtrim($expectedValue, '.');
                $priorityMatches = $priority === null || ((int) $mxPriority === (int) $priority);

                if ($targetMatches && $priorityMatches) {
                    return true;
                }
            }
        }

        return false;
    }

    private function toDnsType(string $type): int
    {
        return match (strtoupper($type)) {
            'TXT' => DNS_TXT,
            'MX' => DNS_MX,
            default => DNS_ANY,
        };
    }
}

