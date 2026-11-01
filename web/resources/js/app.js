import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Scroll-reveal gaya useInView: sekali tampil, dukung stagger dan delay, hormati prefers-reduced-motion.
(function () {
    var semua = document.querySelectorAll('.reveal');
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        semua.forEach((el) => el.classList.add('is-visible'));
        return;
    }
    document.querySelectorAll('[data-reveal-stagger]').forEach((induk) => {
        induk.querySelectorAll('.reveal').forEach((el, i) => {
            if (!el.hasAttribute('data-reveal-delay')) {
                el.style.transitionDelay = Math.min(i, 8) * 70 + 'ms';
            }
        });
    });
    document.querySelectorAll('[data-reveal-delay]').forEach((el) => {
        el.style.transitionDelay = el.getAttribute('data-reveal-delay') + 'ms';
    });
    function tampilkan(el) {
        el.classList.add('is-visible');
        el.addEventListener('transitionend', function hapus() {
            el.style.transitionDelay = '0ms';
            el.removeEventListener('transitionend', hapus);
        });
    }
    if ('IntersectionObserver' in window) {
        var tampil = new IntersectionObserver((masuk) => {
            masuk.forEach((item) => {
                if (item.isIntersecting) {
                    tampilkan(item.target);
                    tampil.unobserve(item.target);
                }
            });
        }, { threshold: 0.15 });
        semua.forEach((el) => tampil.observe(el));
    } else {
        semua.forEach(tampilkan);
    }
})();
