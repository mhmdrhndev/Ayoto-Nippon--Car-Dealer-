<script>
    (function () {
        try {
            var tersimpan = localStorage.getItem('theme');
            var gelap = tersimpan ? tersimpan === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', gelap);
        } catch (e) {}
    })();
</script>
