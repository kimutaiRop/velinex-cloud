<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Domain;
use App\Models\MailPlan;
use App\Services\MailAnalyticsService;
use App\Services\DomainDnsTemplateService;
use App\Services\DomainDnsVerificationService;
use App\Services\IredMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;

class MailDomainController extends Controller
{
    public function __construct(
        private readonly DomainDnsTemplateService $dnsTemplateService,
        private readonly DomainDnsVerificationService $dnsVerificationService,
        private readonly MailAnalyticsService $mailAnalyticsService,
        private readonly IredMailService $iredMailService
    ) {}

    public function index(): View
    {
        $user = Auth::user();
        $domains = Domain::with(['client', 'dnsRecords', 'mailboxes', 'mailPlan'])
            ->where('client_id', $user->client_id)
            ->latest('updated_at')
            ->get();

        $recentDomains = $domains->take(5);
        $analyticsSummary = $this->mailAnalyticsService->getClientSummary((int) $user->client_id);
        $analyticsByDomain = $this->mailAnalyticsService->getDomainBreakdown($recentDomains->pluck('id'));

        return view('mail.index', [
            'domains' => $recentDomains,
            'totalDomains' => $domains->count(),
            'analyticsSummary' => $analyticsSummary,
            'analyticsByDomain' => $analyticsByDomain,
        ]);
    }

    public function manage(): View
    {
        $user = Auth::user();

        return view('mail.domains', [
            'plans' => MailPlan::active()->get(),
            'domains' => Domain::with(['client', 'dnsRecords', 'mailboxes'])
                ->with('mailPlan')
                ->where('client_id', $user->client_id)
                ->latest('updated_at')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('mail.create', [
            'plans' => MailPlan::active()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['nullable', 'string', 'max:150'],
            'domain' => ['required', 'string', 'max:190', 'regex:/^(?!-)(?:[a-zA-Z0-9-]{1,63}\.)+[A-Za-z]{2,}$/', 'unique:domains,domain'],
            'mail_plan_id' => ['required', Rule::exists('mail_plans', 'id')->where(fn ($query) => $query->where('is_active', true))],
        ]);

        $user = Auth::user();

        $fallbackClientName = ($validated['client_name'] ?? null) ?: $user->name . ' Client';
        $client = $user->client ?? Client::firstOrCreate(
            ['slug' => Str::slug($fallbackClientName)],
            ['name' => $fallbackClientName]
        );

        if ($user->client_id === null) {
            $user->client_id = $client->id;
            $user->save();
        }

        $token = Str::random(32);

        $domain = Domain::create([
            'client_id' => $client->id,
            'mail_plan_id' => (int) $validated['mail_plan_id'],
            'domain' => Str::lower($validated['domain']),
            'status' => 'pending',
            'verification_token' => $token,
        ]);

        $records = $this->dnsTemplateService->build($domain->domain, $token);
        $domain->dnsRecords()->createMany($records);

        return redirect()->route('mail.domains.show', $domain)->with(
            'status',
            'Domain created. Add the DNS records below at your registrar/DNS provider.'
        );
    }

    public function show(Domain $domain): View
    {
        abort_if($domain->client_id !== Auth::user()->client_id, 403);
        $domain->load(['client', 'dnsRecords', 'mailPlan']);

        return view('mail.show', [
            'domain' => $domain,
            'verificationResults' => session('verification_results'),
            'mailboxes' => $domain->mailboxes()->latest()->get(),
        ]);
    }

    public function mailboxes(Domain $domain): View
    {
        abort_if($domain->client_id !== Auth::user()->client_id, 403);
        $domain->load(['client', 'mailPlan']);
        $canManageRouting = $domain->mailPlan?->supportsAliasesForwarders() ?? false;

        $aliases = [];
        $forwardingByMailbox = [];
        if ($canManageRouting) {
            try {
                $aliases = $this->iredMailService->listDomainAliases($domain->domain);
                foreach ($domain->mailboxes()->get(['id', 'email']) as $mailbox) {
                    $forwardingByMailbox[$mailbox->id] = $this->iredMailService->getMailboxForwarding($mailbox->email);
                }
            } catch (RuntimeException) {
                // Keep dashboard usable even if routing tables are unavailable.
            }
        }

        return view('mail.mailboxes', [
            'domain' => $domain,
            'mailboxes' => $domain->mailboxes()->latest()->get(),
            'aliases' => $aliases,
            'forwardingByMailbox' => $forwardingByMailbox,
            'canManageRouting' => $canManageRouting,
        ]);
    }

    public function verify(Domain $domain): RedirectResponse
    {
        abort_if($domain->client_id !== Auth::user()->client_id, 403);
        $domain->load('dnsRecords');

        $verification = $this->dnsVerificationService->verify($domain);
        if ($verification['all_valid']) {
            $domain->iredmail_provisioned = false;
            $domain->save();
        }

        return redirect()
            ->route('mail.domains.show', $domain)
            ->with('status', $verification['all_valid']
                ? 'Domain is verified. All required DNS records were found.'
                : 'Domain is still pending. Some DNS records are missing or not propagated yet.'
            )
            ->with('verification_results', $verification['records']);
    }

    public function toggleDomain(Domain $domain): RedirectResponse
    {
        abort_if($domain->client_id !== Auth::user()->client_id, 403);

        $targetStatus = $domain->status === 'disabled' ? 'pending' : 'disabled';

        try {
            $this->iredMailService->setDomainActive($domain->domain, $targetStatus !== 'disabled');
        } catch (RuntimeException $e) {
            return back()->with('status', 'iRedMail error: ' . $e->getMessage());
        }

        $domain->status = $targetStatus;
        $domain->save();

        return back()->with('status', $targetStatus === 'disabled'
            ? 'Domain has been disabled.'
            : 'Domain has been re-enabled.'
        );
    }

    public function destroy(Request $request, Domain $domain): RedirectResponse
    {
        abort_if($domain->client_id !== Auth::user()->client_id, 403);

        $force = $request->boolean('force_delete');
        $mailboxes = $domain->mailboxes()->get();
        if (!$force && $mailboxes->isNotEmpty()) {
            return back()->withErrors([
                'domain_delete' => 'This domain has existing mailboxes. Confirm force delete to proceed.',
            ]);
        }

        foreach ($mailboxes as $mailbox) {
            try {
                $this->iredMailService->deleteMailbox($mailbox->email);
            } catch (RuntimeException) {
                // best effort cleanup in iRedMail
            }
        }

        try {
            $this->iredMailService->deleteDomain($domain->domain);
        } catch (RuntimeException) {
            // best effort cleanup in iRedMail
        }

        $domain->delete();

        return redirect()->route('mail.domains.manage')->with('status', 'Domain deleted.');
    }

    public function updatePlan(Request $request, Domain $domain): RedirectResponse
    {
        abort_if($domain->client_id !== Auth::user()->client_id, 403);

        $validated = $request->validate([
            'mail_plan_id' => ['required', Rule::exists('mail_plans', 'id')->where(fn ($query) => $query->where('is_active', true))],
        ]);

        $targetPlan = MailPlan::query()->findOrFail((int) $validated['mail_plan_id']);
        $domain->mail_plan_id = $targetPlan->id;
        $domain->save();

        $updatedCount = 0;
        $failed = [];
        $targetQuota = (int) $targetPlan->storage_mb;

        foreach ($domain->mailboxes()->get() as $mailbox) {
            $newQuota = min((int) $mailbox->quota_mb, $targetQuota);

            try {
                $this->iredMailService->updateMailboxQuota($mailbox->email, $newQuota);
            } catch (RuntimeException $e) {
                $failed[] = $mailbox->email;
                continue;
            }

            if ((int) $mailbox->quota_mb !== $newQuota) {
                $mailbox->quota_mb = $newQuota;
                $mailbox->save();
            }
            $updatedCount++;
        }

        if (!empty($failed)) {
            return back()->with('status', 'Plan updated, but quota sync failed for: ' . implode(', ', $failed));
        }

        return back()->with('status', "Plan updated to {$targetPlan->name}. Synced {$updatedCount} mailbox quota(s).");
    }
}

