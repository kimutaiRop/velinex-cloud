<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Mailbox;
use App\Services\IredMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class MailRoutingController extends Controller
{
    public function __construct(private readonly IredMailService $iredMailService)
    {
    }

    public function storeAlias(Request $request, Domain $domain): RedirectResponse
    {
        $this->authorizeDomain($domain);
        $this->ensureRoutingAllowed($domain);

        $validated = $request->validate([
            'alias_local_part' => ['required', 'string', 'max:120', 'regex:/^[a-z0-9._-]+$/i'],
            'destinations' => ['required', 'string', 'max:1000'],
        ]);

        $aliasEmail = strtolower($validated['alias_local_part']) . '@' . $domain->domain;
        $destinations = $this->extractDestinations($validated['destinations']);
        if (!$this->allEmailsValid($destinations)) {
            return back()->withErrors(['destinations' => 'All alias destinations must be valid email addresses.'])->withInput();
        }

        try {
            $this->iredMailService->createAlias($aliasEmail, $destinations);
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        return back()->with('status', 'Alias created.');
    }

    public function deleteAlias(Domain $domain, string $address): RedirectResponse
    {
        $this->authorizeDomain($domain);
        $this->ensureRoutingAllowed($domain);

        try {
            $this->iredMailService->deleteAlias($address);
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        return back()->with('status', 'Alias removed.');
    }

    public function updateForwarding(Request $request, Mailbox $mailbox): RedirectResponse
    {
        $this->authorizeMailbox($mailbox);
        $domain = $mailbox->domain;
        $this->ensureRoutingAllowed($domain);

        $validated = $request->validate([
            'forward_to' => ['nullable', 'string', 'max:1000'],
            'keep_copy' => ['nullable', 'boolean'],
        ]);

        $destinations = $this->extractDestinations($validated['forward_to'] ?? '');
        if (!empty($destinations) && !$this->allEmailsValid($destinations)) {
            return back()->withErrors(['forward_to' => 'All forwarding destinations must be valid email addresses.'])->withInput();
        }
        $keepCopy = (bool) ($validated['keep_copy'] ?? false);

        if (empty($destinations) && !$keepCopy) {
            return back()->withErrors(['forward_to' => 'Provide at least one destination or keep local copy enabled.']);
        }

        try {
            $this->iredMailService->setMailboxForwarding($mailbox->email, $destinations, $keepCopy);
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        return back()->with('status', 'Forwarding updated for ' . $mailbox->email . '.');
    }

    private function extractDestinations(string $input): array
    {
        return array_values(array_filter(array_map(function ($entry) {
            return strtolower(trim($entry));
        }, preg_split('/[\s,;]+/', $input))));
    }

    private function allEmailsValid(array $emails): bool
    {
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        return true;
    }

    private function ensureRoutingAllowed(Domain $domain): void
    {
        abort_unless($domain->mailPlan && $domain->mailPlan->supportsAliasesForwarders(), 403, 'Plan does not include aliases/forwarders.');
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
