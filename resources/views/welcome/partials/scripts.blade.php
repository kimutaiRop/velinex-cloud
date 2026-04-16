<script>
(function () {
    const mq = window.matchMedia('(max-width: 767px)');
    const openBtn = document.getElementById('nav-menu-open');
    const backdrop = document.getElementById('nav-drawer-backdrop');
    const drawer = document.getElementById('nav-drawer');
    if (!openBtn || !backdrop || !drawer) return;

    function setOpen(open) {
        openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        backdrop.setAttribute('aria-hidden', open ? 'false' : 'true');
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');

        backdrop.classList.toggle('hidden', !open);
        backdrop.classList.toggle('pointer-events-none', !open);
        backdrop.classList.toggle('opacity-0', !open);

        drawer.classList.toggle('pointer-events-none', !open);
        drawer.classList.toggle('translate-x-full', !open);

        document.body.style.overflow = open ? 'hidden' : '';
    }

    function closeIfMobile() {
        if (mq.matches) setOpen(false);
    }

    openBtn.addEventListener('click', () => {
        const isOpen = openBtn.getAttribute('aria-expanded') === 'true';
        setOpen(!isOpen);
    });

    backdrop.addEventListener('click', closeIfMobile);
    drawer.querySelectorAll('a').forEach(a => a.addEventListener('click', closeIfMobile));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeIfMobile(); });
    setOpen(false);
})();
</script>
