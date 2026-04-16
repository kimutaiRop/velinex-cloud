<!-- CTA -->
<section class="cta-section">
    <div class="cta-geo">
        <svg viewBox="0 0 420 400" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMid slice">
            <line x1="0" y1="0" x2="420" y2="400" stroke="white" stroke-width="1"/>
            <line x1="60" y1="0" x2="420" y2="340" stroke="white" stroke-width="1"/>
            <line x1="120" y1="0" x2="420" y2="280" stroke="white" stroke-width="1"/>
            <line x1="180" y1="0" x2="420" y2="220" stroke="white" stroke-width="1"/>
            <line x1="240" y1="0" x2="420" y2="160" stroke="white" stroke-width="1"/>
            <line x1="300" y1="0" x2="420" y2="100" stroke="white" stroke-width="1"/>
            <line x1="360" y1="0" x2="420" y2="40"  stroke="white" stroke-width="1"/>
            <circle cx="380" cy="80"  r="60"  stroke="white" stroke-width="1" fill="none"/>
            <circle cx="380" cy="80"  r="110" stroke="white" stroke-width="1" fill="none"/>
        </svg>
    </div>
    <div class="cta-ring"></div>
    <div class="cta-ring-2"></div>
    <div class="wrap">
        <div class="cta-inner reveal">
            <div class="cta-text">
                <div class="cta-h2">Ready to take control<br>of your infrastructure?</div>
                <p class="cta-sub">Join businesses across East Africa running their web and email on Velinex Cloud. Get started free — no credit card needed.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('auth.register') }}" class="cta-btn-primary">
                    Start for free
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ route('login') }}" class="cta-btn-secondary">Sign in to dashboard →</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="wrap footer-inner">
        <div class="footer-brand">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="nav-logo" style="width:102px;">
        </div>
        <span class="footer-copy">© {{ date('Y') }} Velinex Labs. All rights reserved.</span>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</footer>
