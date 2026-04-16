<?php

namespace Database\Seeders;

use App\Models\MailPlan;
use Illuminate\Database\Seeder;

class MailPlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'        => 'Free',
                'slug'        => 'free',
                'description' => 'Get started with business email at no cost.',
                'price_kes'   => 0,
                'storage_mb'  => 100,
                'max_domains' => 1,
                'features'    => [
                    'Unlimited mailboxes per domain',
                    '100 MB storage per mailbox',
                    '1 domain',
                    'Webmail access (Roundcube)',
                    'IMAP / SMTP / POP3',
                    'Auto SPF, DKIM & DMARC',
                    'Community support',
                ],
                'is_featured' => false,
                'is_active'   => true,
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Starter',
                'slug'        => 'starter',
                'description' => 'Perfect for small businesses and growing teams.',
                'price_kes'   => 800,
                'storage_mb'  => 2048,   // 2 GB
                'max_domains' => 5,
                'features'    => [
                    'Unlimited mailboxes per domain',
                    '2 GB storage per mailbox',
                    'Up to 5 domains',
                    'Webmail access (Roundcube)',
                    'IMAP / SMTP / POP3',
                    'Auto SPF, DKIM & DMARC',
                    'Spam & virus filtering',
                    'Email support (48 h SLA)',
                ],
                'is_featured' => false,
                'is_active'   => true,
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Business',
                'slug'        => 'business',
                'description' => 'For teams that rely on email as a core business tool.',
                'price_kes'   => 2000,
                'storage_mb'  => 10240,  // 10 GB
                'max_domains' => 15,
                'features'    => [
                    'Unlimited mailboxes per domain',
                    '10 GB storage per mailbox',
                    'Up to 15 domains',
                    'Webmail access (Roundcube)',
                    'IMAP / SMTP / POP3',
                    'Auto SPF, DKIM & DMARC',
                    'Advanced spam & virus filtering',
                    'Mail aliases & forwarders',
                    'Priority email support (24 h SLA)',
                    'Monthly usage reports',
                ],
                'is_featured' => true,
                'is_active'   => true,
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Enterprise',
                'slug'        => 'enterprise',
                'description' => 'Unlimited scale for agencies and large organisations.',
                'price_kes'   => 5000,
                'storage_mb'  => 51200,  // 50 GB
                'max_domains' => null,   // unlimited
                'features'    => [
                    'Unlimited mailboxes per domain',
                    '50 GB storage per mailbox',
                    'Unlimited domains',
                    'Webmail access (Roundcube)',
                    'IMAP / SMTP / POP3',
                    'Auto SPF, DKIM & DMARC',
                    'Advanced spam & virus filtering',
                    'Mail aliases & forwarders',
                    'Dedicated IP for outbound mail',
                    'REST API access',
                    'Dedicated support (4 h SLA)',
                    'Custom SLA on request',
                ],
                'is_featured' => false,
                'is_active'   => true,
                'sort_order'  => 4,
            ],
        ];

        foreach ($plans as $plan) {
            MailPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
