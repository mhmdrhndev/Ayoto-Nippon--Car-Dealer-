@props(['items', 'skala', 'klik' => false])
@php
    $lebar = 600; $tinggi = 260; $kiri = 64; $kanan = 12; $atas = 28; $bawah = 44;
    $plotL = $lebar - $kiri - $kanan; $plotT = $tinggi - $atas - $bawah;
    $n = count($items);
    $titik = [];
    foreach ($items as $i => $bar) {
        $x = $kiri + ($n > 1 ? $i * $plotL / ($n - 1) : $plotL / 2);
        $y = $atas + $plotT - ($bar['nominal'] / $skala) * $plotT;
        $titik[] = [round($x, 1), round($y, 1)];
    }
    $garis = implode(' ', array_map(fn ($t) => $t[0].','.$t[1], $titik));
    $ringkas = function ($rp) {
        if ($rp >= 1000000000) {
            return 'Rp '.rtrim(rtrim(number_format($rp / 1000000000, 1, ',', '.'), '0'), ',').' M';
        }
        if ($rp >= 1000000) {
            return 'Rp '.rtrim(rtrim(number_format($rp / 1000000, 1, ',', '.'), '0'), ',').' jt';
        }

        return 'Rp '.number_format($rp, 0, ',', '.');
    };
@endphp
<svg viewBox="0 0 {{ $lebar }} {{ $tinggi }}" class="mt-4 w-full h-auto" role="img" aria-label="Grafik omzet">
    @for ($g = 0; $g <= 4; $g++)
        @php $gy = $atas + $plotT - ($g / 4) * $plotT; @endphp
        <line x1="{{ $kiri }}" y1="{{ $gy }}" x2="{{ $lebar - $kanan }}" y2="{{ $gy }}" stroke="#E5E7EB" stroke-width="1" />
                                <text x="{{ $kiri - 6 }}" y="{{ $gy + 4 }}" text-anchor="end" font-size="11" fill="#6B7280">{{ $ringkas($skala * $g / 4) }}</text>
    @endfor
    <polyline points="{{ $garis }}" fill="none" stroke="#C1121F" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
    @foreach ($items as $i => $bar)
        @if ($klik && ! empty($bar['kunci']))
            <g @click="level = 'bulan'; tahun = '{{ $bar['kunci'] }}'" class="cursor-pointer" tabindex="0" role="button" aria-label="Lihat bulan {{ $bar['label'] }}" @keydown.enter="level = 'bulan'; tahun = '{{ $bar['kunci'] }}'">
                <circle cx="{{ $titik[$i][0] }}" cy="{{ $titik[$i][1] }}" r="8" fill="transparent" />
                <circle cx="{{ $titik[$i][0] }}" cy="{{ $titik[$i][1] }}" r="4" fill="#C1121F" stroke="#fff" stroke-width="1.5" />
            </g>
        @else
            <circle cx="{{ $titik[$i][0] }}" cy="{{ $titik[$i][1] }}" r="4" fill="#C1121F" stroke="#fff" stroke-width="1.5" />
        @endif
        <text x="{{ $titik[$i][0] }}" y="{{ $titik[$i][1] - 9 }}" text-anchor="{{ $i === 0 ? 'start' : ($i === count($items) - 1 ? 'end' : 'middle') }}" font-size="11" font-weight="bold" fill="#16181D">{{ $ringkas($bar['nominal']) }}</text>
        <text x="{{ $titik[$i][0] }}" y="{{ $tinggi - 26 }}" text-anchor="middle" font-size="11" fill="#6B7280">{{ $bar['label'] }}</text>
        <text x="{{ $titik[$i][0] }}" y="{{ $tinggi - 11 }}" text-anchor="middle" font-size="10" fill="#4B5563">{{ $bar['unit'] }} unit</text>
    @endforeach
</svg>
