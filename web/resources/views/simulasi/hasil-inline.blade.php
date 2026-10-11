<p class="text-sm text-[#4B5563]">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }} via {{ $leasing->nama }}</p>
<p class="mt-1 text-sm text-[#16181D]">Harga OTR: <span class="font-semibold tabular-nums">Rp {{ number_format($otr, 0, ',', '.') }}</span></p>
<p class="mt-3 text-sm text-[#4B5563]">Estimasi angsuran</p>
<p class="text-3xl font-bold text-[#16181D] tabular-nums">Rp {{ number_format($angsuran, 0, ',', '.') }}<span class="text-base font-medium">/bulan x {{ $tenor }}</span></p>
<p class="mt-2 text-xs text-[#4B5563]">Estimasi kasar dengan bunga flat {{ $leasing->bunga_dasar }}% per tahun. Angka final mengikuti persetujuan leasing.</p>
<p class="mt-2 text-sm text-[#4B5563]">Hasil ini sudah tersimpan. Sales kami akan menghubungi Anda.</p>
