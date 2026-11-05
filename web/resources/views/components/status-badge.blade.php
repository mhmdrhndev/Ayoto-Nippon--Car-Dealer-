@props(['status'])
@php
$map = [
    'Tersedia' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
    'MenungguBayar' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
    'Menunggu' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
    'Diajukan' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
    'MenungguVerifikasi' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
    'Dikonfirmasi' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
    'Dikerjakan' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
    'Inspeksi' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
    'Ditawar' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
    'Deal' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
    'Selesai' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
    'Hadir' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
    'Ditolak' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
    'Batal' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
    'Expired' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
    'Dipesan' => 'bg-[#F3F4F6] text-[#4B5563] ring-1 ring-[#E5E7EB]',
    'Terjual' => 'bg-[#F3F4F6] text-[#4B5563] ring-1 ring-[#E5E7EB]',
    'Lunas' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
];
$kelas = $map[$status] ?? 'bg-[#F3F4F6] text-[#4B5563] ring-1 ring-[#E5E7EB]';
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold $kelas"]) }}>{{ $status }}</span>
