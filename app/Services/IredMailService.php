<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
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
}

