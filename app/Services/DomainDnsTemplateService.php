<?php

namespace App\Services;

class DomainDnsTemplateService
{
    public function build(string $domain, string $verificationToken): array
    {
        $selector = 'default';
        $dkimHost = $selector . '._domainkey.' . $domain;

        return [
            [
                'type' => 'TXT',
                'host' => $domain,
                'value' => 'v=spf1 mx a include:' . $domain . ' ~all',
                'priority' => null,
            ],
            [
                'type' => 'TXT',
                'host' => '_dmarc.' . $domain,
                'value' => 'v=DMARC1; p=none; rua=mailto:dmarc@' . $domain . '; adkim=s; aspf=s',
                'priority' => null,
            ],
            [
                'type' => 'TXT',
                'host' => $dkimHost,
                'value' => 'v=DKIM1; k=rsa; p=REPLACE_WITH_GENERATED_PUBLIC_KEY',
                'priority' => null,
            ],
            [
                'type' => 'TXT',
                'host' => '_velinex-verify.' . $domain,
                'value' => 'velinex-verification=' . $verificationToken,
                'priority' => null,
            ],
            [
                'type' => 'MX',
                'host' => $domain,
                'value' => 'mail.velinexlabs.com',
                'priority' => 10,
            ],
        ];
    }
}

