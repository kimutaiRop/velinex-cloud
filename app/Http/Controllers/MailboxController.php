<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Mailbox;
use App\Services\IredMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class MailboxController extends Controller
{
    public function __construct(private readonly IredMailService $iredMailService)
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
            'password' => ['required', 'string', 'min:8'],
            'quota_mb' => ['required', 'integer', 'min:128', 'max:102400'],
        ]);

        $email = strtolower($validated['local_part']) . '@' . $domain->domain;

        try {
            $this->iredMailService->ensureDomain($domain->domain);
            $this->iredMailService->createMailbox($email, $validated['display_name'], $validated['password'], (int) $validated['quota_mb']);
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        Mailbox::updateOrCreate(
            ['email' => $email],
            [
                'domain_id' => $domain->id,
                'client_id' => $domain->client_id,
                'display_name' => $validated['display_name'],
                'quota_mb' => (int) $validated['quota_mb'],
                'active' => true,
            ]
        );

        $domain->iredmail_provisioned = true;
        $domain->save();

        return back()->with('status', 'Mailbox created and linked with iRedMail.');
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

