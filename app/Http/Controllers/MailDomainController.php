<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Domain;
use App\Services\DomainDnsTemplateService;
use App\Services\DomainDnsVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MailDomainController extends Controller
{
    public function __construct(
        private readonly DomainDnsTemplateService $dnsTemplateService,
        private readonly DomainDnsVerificationService $dnsVerificationService
    ) {}

    public function index(): View
    {
        $user = Auth::user();

        return view('mail.index', [
            'domains' => Domain::with(['client', 'dnsRecords'])
                ->where('client_id', $user->client_id)
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('mail.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['nullable', 'string', 'max:150'],
            'domain' => ['required', 'string', 'max:190', 'regex:/^(?!-)(?:[a-zA-Z0-9-]{1,63}\.)+[A-Za-z]{2,}$/', 'unique:domains,domain'],
        ]);

        $user = Auth::user();

        $fallbackClientName = $validated['client_name'] ?: $user->name . ' Client';
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
        $domain->load(['client', 'dnsRecords']);

        return view('mail.show', [
            'domain' => $domain,
            'verificationResults' => session('verification_results'),
            'mailboxes' => $domain->mailboxes()->latest()->get(),
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
}

