<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Mailbox;
use App\Services\IredMailService;
use App\Services\MailboxCredentialDeliveryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RuntimeException;

class MailboxController extends Controller
{
    public function __construct(
        private readonly IredMailService $iredMailService,
        private readonly MailboxCredentialDeliveryService $credentialDeliveryService
    )
    {
    }

    public function store(Request $request, Domain $domain): RedirectResponse
    {
        $this->authorizeDomain($domain);

        if ($domain->status !== 'verified') {
            return back()->with('status', 'Domain must be verified before creating mailboxes.');
        }

        $validated = $request->validate([
            'local_part' => ['required', 'string', 'max:120', 'regex:/^[a-z0-9._-]+$/i'],
            'display_name' => ['required', 'string', 'max:190'],
            'password_mode' => ['required', 'in:manual,generated,generated_email'],
            'password' => ['nullable', 'string', 'min:8'],
            'secondary_email' => ['nullable', 'email', 'max:190'],
            'require_initial_reset' => ['nullable', 'boolean'],
            'quota_mb' => ['required', 'integer', 'min:128', 'max:102400'],
        ]);

        if ($validated['password_mode'] === 'manual' && empty($validated['password'])) {
            return back()->withErrors(['password' => 'Password is required for manual mode.'])->withInput();
        }

        if ($validated['password_mode'] === 'generated_email' && empty($validated['secondary_email'])) {
            return back()->withErrors(['secondary_email' => 'Secondary email is required for credential delivery.'])->withInput();
        }

        $email = strtolower($validated['local_part']) . '@' . $domain->domain;
        $plainPassword = $validated['password_mode'] === 'manual'
            ? $validated['password']
            : Str::password(16);
        $requireInitialReset = (bool) ($validated['require_initial_reset'] ?? false);
        $deliveryStatus = null;
        $passwordSharedAt = null;

        try {
            $this->iredMailService->ensureDomain($domain->domain);
            $this->iredMailService->createMailbox($email, $validated['display_name'], $plainPassword, (int) $validated['quota_mb']);
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        $mailbox = Mailbox::updateOrCreate(
            ['email' => $email],
            [
                'domain_id' => $domain->id,
                'client_id' => $domain->client_id,
                'display_name' => $validated['display_name'],
                'quota_mb' => (int) $validated['quota_mb'],
                'password_mode' => $validated['password_mode'],
                'secondary_email' => $validated['secondary_email'] ?? null,
                'require_initial_reset' => $requireInitialReset,
                'last_password_reset_at' => now(),
                'password_delivery_status' => null,
                'active' => true,
            ]
        );

        if ($validated['password_mode'] === 'generated_email') {
            $deliveryStatus = $this->credentialDeliveryService->sendInitialPassword(
                $mailbox,
                $domain,
                $plainPassword,
                $validated['secondary_email']
            );
            $passwordSharedAt = $deliveryStatus === 'sent' ? now() : null;
            $mailbox->password_delivery_status = $deliveryStatus;
            $mailbox->password_shared_at = $passwordSharedAt;
            $mailbox->save();
        }

        $domain->iredmail_provisioned = true;
        $domain->save();

        $statusMessage = 'Mailbox created and linked with iRedMail.';
        if ($validated['password_mode'] === 'generated_email') {
            $statusMessage .= $deliveryStatus === 'sent'
                ? ' Credentials were sent to secondary email.'
                : ' Failed to send secondary email. Please copy password from this screen and share securely.';
        }

        return back()
            ->with('status', $statusMessage)
            ->with('generated_mailbox_password', $validated['password_mode'] === 'manual' ? null : $plainPassword)
            ->with('generated_mailbox_email', $validated['password_mode'] === 'manual' ? null : $email);
    }

    public function updatePassword(Request $request, Mailbox $mailbox): RedirectResponse
    {
        $this->authorizeMailbox($mailbox);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        try {
            $this->iredMailService->updateMailboxPassword($mailbox->email, $validated['password']);
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        $mailbox->last_password_reset_at = now();
        $mailbox->require_initial_reset = false;
        $mailbox->save();

        return back()->with('status', 'Mailbox password updated in iRedMail.');
    }

    public function toggle(Mailbox $mailbox): RedirectResponse
    {
        $this->authorizeMailbox($mailbox);

        $targetState = !$mailbox->active;

        try {
            $this->iredMailService->setMailboxActive($mailbox->email, $targetState);
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        $mailbox->active = $targetState;
        $mailbox->save();

        return back()->with('status', 'Mailbox status updated.');
    }

    private function authorizeDomain(Domain $domain): void
    {
        abort_if($domain->client_id !== Auth::user()->client_id, 403);
    }

    private function authorizeMailbox(Mailbox $mailbox): void
    {
        abort_if($mailbox->client_id !== Auth::user()->client_id, 403);
    }
}

