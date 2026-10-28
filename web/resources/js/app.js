import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Scroll-reveal sekali tampil; hormati prefers-reduced-motion.
if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-visible'));
} else if ('IntersectionObserver' in window) {
    const tampil = new IntersectionObserver((masuk) => {
        masuk.forEach((item) => {
            if (item.isIntersecting) {
                item.target.classList.add('is-visible');
                tampil.unobserve(item.target);
            }
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('.reveal').forEach((el) => tampil.observe(el));
} else {
    document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-visible'));
}
