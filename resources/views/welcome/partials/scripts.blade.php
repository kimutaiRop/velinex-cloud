const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => io.observe(el));

(function () {
    const mq = window.matchMedia('(max-width: 760px)');
    const openBtn = document.getElementById('nav-menu-open');
    const backdrop = document.getElementById('nav-drawer-backdrop');
    const drawer = document.getElementById('nav-drawer');
    if (!openBtn || !backdrop || !drawer) return;

    function setOpen(open) {
        document.body.classList.toggle('nav-drawer-open', open);
        openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        backdrop.setAttribute('aria-hidden', open ? 'false' : 'true');
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.body.style.overflow = open ? 'hidden' : '';
    }

    function closeIfMobile() {
        if (mq.matches) setOpen(false);
    }

    openBtn.addEventListener('click', () => setOpen(!document.body.classList.contains('nav-drawer-open')));
    backdrop.addEventListener('click', closeIfMobile);
    drawer.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => closeIfMobile());
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeIfMobile();
    });
    if (mq.addEventListener) {
        mq.addEventListener('change', e => { if (!e.matches) setOpen(false); });
    } else if (mq.addListener) {
        mq.addListener(e => { if (!e.matches) setOpen(false); });
    }
})();
