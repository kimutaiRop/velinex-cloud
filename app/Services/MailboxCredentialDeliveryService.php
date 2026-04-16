<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\Mailbox;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MailboxCredentialDeliveryService
{
    public function sendInitialPassword(Mailbox $mailbox, Domain $domain, string $password, string $targetEmail): string
    {
        try {
            Mail::raw(
                "A new mailbox has been created for {$domain->domain}.\n\nMailbox: {$mailbox->email}\nTemporary Password: {$password}\n\nPlease sign in and change your password immediately.",
                function ($message) use ($targetEmail, $mailbox): void {
                    $message->to($targetEmail)
                        ->subject("Mailbox credentials for {$mailbox->email}");
                }
            );

            return 'sent';
        } catch (Throwable) {
            return 'failed';
        }
    }
}

