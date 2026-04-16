<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use RuntimeException;

class IredMailService
{
    public function ensureDomain(string $domain): void
    {
        $exists = DB::connection('iredmail')->table('domain')->where('domain', $domain)->exists();
        if ($exists) {
            return;
        }

        $now = now()->toDateTimeString();

        DB::connection('iredmail')->table('domain')->insert([
            'domain' => $domain,
            'description' => $domain,
            'aliases' => 100,
            'mailboxes' => 100,
            'maillists' => 20,
            'maxquota' => 0,
            'quota' => 0,
            'transport' => 'dovecot',
            'backupmx' => 0,
            'created' => $now,
            'modified' => $now,
            'expired' => '9999-12-31 00:00:00',
            'active' => 1,
        ]);
    }

    public function createMailbox(string $email, string $displayName, string $plainPassword, int $quotaMb): void
    {
        [$localPart, $domain] = $this->splitEmail($email);

        $this->ensureDomain($domain);

        $maildir = $this->buildMaildir($domain, $localPart);
        $now = now()->toDateTimeString();

        DB::connection('iredmail')->table('mailbox')->insert([
            'username' => $email,
            'password' => $this->makeSsha512($plainPassword),
            'name' => $displayName,
            'language' => 'en_US',
            'first_name' => '',
            'last_name' => '',
            'mobile' => '',
            'telephone' => '',
            'recovery_email' => '',
            'birthday' => '0001-01-01',
            'mailboxformat' => 'maildir',
            'mailboxfolder' => 'Maildir',
            'storagebasedirectory' => '/var/vmail',
            'storagenode' => 'vmail1',
            'maildir' => $maildir,
            'quota' => $quotaMb,
            'domain' => $domain,
            'transport' => 'dovecot',
            'department' => '',
            'rank' => 'normal',
            'employeeid' => '',
            'isadmin' => 0,
            'isglobaladmin' => 0,
            'enablesmtp' => 1,
            'enablesmtpsecured' => 1,
            'enablepop3' => 1,
            'enablepop3secured' => 1,
            'enablepop3tls' => 1,
            'enableimap' => 1,
            'enableimapsecured' => 1,
            'enableimaptls' => 1,
            'enabledeliver' => 1,
            'enablelda' => 1,
            'enablemanagesieve' => 1,
            'enablemanagesievesecured' => 1,
            'enablesieve' => 1,
            'enablesievesecured' => 1,
            'enablesievetls' => 1,
            'enableinternal' => 1,
            'enabledoveadm' => 1,
            'enablelib-storage' => 1,
            'enablequota-status' => 1,
            'enableindexer-worker' => 1,
            'enablelmtp' => 1,
            'enabledsync' => 1,
            'enablesogo' => 1,
            'enablesogowebmail' => 'y',
            'enablesogocalendar' => 'y',
            'enablesogoactivesync' => 'y',
            'allow_nets' => null,
            'disclaimer' => null,
            'settings' => null,
            'passwordlastchange' => $now,
            'created' => $now,
            'modified' => $now,
            'expired' => '9999-12-31 00:00:00',
            'active' => 1,
        ]);
    }

    public function updateMailboxPassword(string $email, string $plainPassword): void
    {
        $updated = DB::connection('iredmail')->table('mailbox')
            ->where('username', $email)
            ->update([
                'password' => $this->makeSsha512($plainPassword),
                'passwordlastchange' => now()->toDateTimeString(),
                'modified' => now()->toDateTimeString(),
            ]);

        if ($updated === 0) {
            throw new RuntimeException('Mailbox not found in iRedMail.');
        }
    }

    public function setMailboxActive(string $email, bool $active): void
    {
        $updated = DB::connection('iredmail')->table('mailbox')
            ->where('username', $email)
            ->update([
                'active' => $active ? 1 : 0,
                'enabledeliver' => $active ? 1 : 0,
                'modified' => now()->toDateTimeString(),
            ]);

        if ($updated === 0) {
            throw new RuntimeException('Mailbox not found in iRedMail.');
        }
    }

    public function deleteMailbox(string $email): void
    {
        DB::connection('iredmail')->table('mailbox')
            ->where('username', $email)
            ->delete();
    }

    public function setDomainActive(string $domain, bool $active): void
    {
        DB::connection('iredmail')->table('domain')
            ->where('domain', $domain)
            ->update([
                'active' => $active ? 1 : 0,
                'modified' => now()->toDateTimeString(),
            ]);
    }

    public function deleteDomain(string $domain): void
    {
        DB::connection('iredmail')->table('domain')
            ->where('domain', $domain)
            ->delete();
    }

    public function listDomainAliases(string $domain): array
    {
        try {
            $rows = DB::connection('iredmail')->table('alias')
                ->where('domain', $domain)
                ->where('address', 'like', '%@' . $domain)
                ->orderBy('address')
                ->get(['address', 'goto', 'active']);
        } catch (QueryException $e) {
            throw new RuntimeException('Unable to read aliases from iRedMail: ' . $e->getMessage());
        }

        return $rows->map(function ($row) {
            return [
                'address' => $row->address,
                'destinations' => $this->parseGoto((string) $row->goto),
                'active' => (bool) $row->active,
            ];
        })->all();
    }

    public function createAlias(string $aliasEmail, array $destinations): void
    {
        [$localPart, $domain] = $this->splitEmail($aliasEmail);
        $this->ensureDomain($domain);
        $now = now()->toDateTimeString();

        $goto = $this->buildGoto($destinations);

        try {
            DB::connection('iredmail')->table('alias')->updateOrInsert(
                ['address' => strtolower($localPart . '@' . $domain)],
                [
                    'name' => $localPart,
                    'goto' => $goto,
                    'domain' => strtolower($domain),
                    'active' => 1,
                    'modified' => $now,
                    'created' => $now,
                    'expired' => '9999-12-31 00:00:00',
                ]
            );
        } catch (QueryException $e) {
            throw new RuntimeException('Unable to create alias in iRedMail: ' . $e->getMessage());
        }
    }

    public function deleteAlias(string $aliasEmail): void
    {
        try {
            DB::connection('iredmail')->table('alias')
                ->where('address', strtolower($aliasEmail))
                ->delete();
        } catch (QueryException $e) {
            throw new RuntimeException('Unable to delete alias in iRedMail: ' . $e->getMessage());
        }
    }

    public function getMailboxForwarding(string $mailboxEmail): array
    {
        try {
            $row = DB::connection('iredmail')->table('alias')
                ->where('address', strtolower($mailboxEmail))
                ->first(['goto']);
        } catch (QueryException $e) {
            throw new RuntimeException('Unable to read forwarding from iRedMail: ' . $e->getMessage());
        }

        if (!$row) {
            return [];
        }

        return array_values(array_filter(
            $this->parseGoto((string) $row->goto),
            fn (string $destination) => strtolower($destination) !== strtolower($mailboxEmail)
        ));
    }

    public function setMailboxForwarding(string $mailboxEmail, array $destinations, bool $keepCopy = true): void
    {
        [$localPart, $domain] = $this->splitEmail($mailboxEmail);
        $email = strtolower($localPart . '@' . $domain);

        $normalizedDestinations = array_values(array_unique(array_map('strtolower', $destinations)));
        if ($keepCopy && !in_array($email, $normalizedDestinations, true)) {
            $normalizedDestinations[] = $email;
        }

        $goto = $this->buildGoto($normalizedDestinations);
        $now = now()->toDateTimeString();

        try {
            DB::connection('iredmail')->table('alias')->updateOrInsert(
                ['address' => $email],
                [
                    'name' => $localPart,
                    'goto' => $goto,
                    'domain' => strtolower($domain),
                    'active' => 1,
                    'modified' => $now,
                    'created' => $now,
                    'expired' => '9999-12-31 00:00:00',
                ]
            );
        } catch (QueryException $e) {
            throw new RuntimeException('Unable to update forwarding in iRedMail: ' . $e->getMessage());
        }
    }

    private function splitEmail(string $email): array
    {
        $parts = explode('@', $email, 2);
        if (count($parts) !== 2) {
            throw new RuntimeException('Invalid mailbox address.');
        }

        return [$parts[0], $parts[1]];
    }

    private function buildMaildir(string $domain, string $localPart): string
    {
        $local = strtolower($localPart);
        $a = $local[0] ?? '_';
        $b = $local[1] ?? '_';
        $c = $local[2] ?? '_';

        return strtolower($domain) . '/' . $a . '/' . $b . '/' . $c . '/' . $local . '/';
    }

    private function makeSsha512(string $plainPassword): string
    {
        $salt = random_bytes(8);
        $digest = hash('sha512', $plainPassword . $salt, true) . $salt;

        return '{SSHA512}' . base64_encode($digest);
    }

    private function buildGoto(array $destinations): string
    {
        $normalized = array_values(array_unique(array_filter(array_map(function ($destination) {
            return strtolower(trim((string) $destination));
        }, $destinations))));

        if (empty($normalized)) {
            throw new RuntimeException('At least one destination is required.');
        }

        return implode(',', $normalized);
    }

    private function parseGoto(string $goto): array
    {
        if ($goto === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $goto))));
    }
}

