<div style="max-width:600px;margin:auto;font-family:Arial,sans-serif;background:#f6f9fc;padding:20px">
    <div style="text-align:center;background:#fff;padding:14px;border-radius:8px;border-top:4px solid #C1121F">
        <img src="cid:logo_ayoto" alt="Ayoto Nippon" style="height:58px"><br><b style="font-size:18px">AYOTO NIPPON</b><br><small style="color:#666">DEALER MOBIL</small>
    </div>
    <div style="background:#fff;border-radius:8px;padding:28px;margin-top:12px">
        <h2 style="margin:0 0 12px">{{ $judul }}</h2>
        @foreach ($baris as $paragraf)
            <p style="font-size:14px;color:#333">{{ $paragraf }}</p>
        @endforeach
        @if (! empty($tombol))
            <p style="margin:20px 0 4px"><a href="{{ $tombol['url'] }}" style="display:inline-block;background:#C1121F;color:#fff;text-decoration:none;font-weight:bold;font-size:14px;padding:12px 24px;border-radius:8px">{{ $tombol['teks'] }}</a></p>
        @endif
        @if (! empty($kontak))
            <p style="font-size:12px;color:#888;margin-top:16px">{{ $kontak }}</p>
        @endif
    </div>
</div>
