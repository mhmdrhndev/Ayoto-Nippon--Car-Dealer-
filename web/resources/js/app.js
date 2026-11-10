import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Ganti tema dengan tirai view transition + kilau bilah, seperti referensi.
window.toggleTheme = function (event) {
    var root = document.documentElement;
    var gelap = !root.classList.contains('dark');
    var tombol = event && event.currentTarget;
    var denyut = tombol ? tombol.querySelector('.theme-pulse') : null;

    if (denyut) {
        denyut.style.background = gelap ? 'rgba(129, 140, 248, .45)' : 'rgba(252, 211, 77, .55)';
        denyut.style.animation = 'pulse-burst 600ms ease-out';
        denyut.addEventListener('animationend', function () { denyut.style.animation = ''; }, { once: true });
    }

    function ganti() {
        root.classList.toggle('dark', gelap);
        try { localStorage.setItem('theme', gelap ? 'dark' : 'light'); } catch (e) {}
    }

    if (document.startViewTransition && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        var kilau = document.createElement('div');
        kilau.className = 'sword-glint slicing';
        document.body.appendChild(kilau);
        var transisi = document.startViewTransition(ganti);
        var bersihkan = function () { kilau.remove(); };
        if (transisi && transisi.finished) {
            transisi.finished.finally(bersihkan);
        } else {
            setTimeout(bersihkan, 950);
        }
        return;
    }

    ganti();
};

// Tanpa pilihan tersimpan, tema mengikuti perubahan sistem.
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
    try {
        if (!localStorage.getItem('theme')) {
            document.documentElement.classList.toggle('dark', e.matches);
        }
    } catch (err) {}
});

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
