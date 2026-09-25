@props(['status'])
@php
$map = [
    'Tersedia' => 'bg-green-100 text-green-900',
    'MenungguBayar' => 'bg-amber-100 text-amber-900',
    'Menunggu' => 'bg-amber-100 text-amber-900',
    'Diajukan' => 'bg-amber-100 text-amber-900',
    'MenungguVerifikasi' => 'bg-blue-100 text-blue-900',
    'Dikonfirmasi' => 'bg-blue-100 text-blue-900',
    'Dikerjakan' => 'bg-blue-100 text-blue-900',
    'Inspeksi' => 'bg-blue-100 text-blue-900',
    'Ditawar' => 'bg-blue-100 text-blue-900',
    'Deal' => 'bg-green-100 text-green-900',
    'Selesai' => 'bg-green-100 text-green-900',
    'Hadir' => 'bg-green-100 text-green-900',
    'Ditolak' => 'bg-red-100 text-red-900',
    'Batal' => 'bg-red-100 text-red-900',
    'Expired' => 'bg-red-100 text-red-900',
    'Dipesan' => 'bg-gray-200 text-gray-800',
    'Terjual' => 'bg-gray-200 text-gray-800',
];
$kelas = $map[$status] ?? 'bg-gray-200 text-gray-800';
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold $kelas"]) }}>{{ $status }}</span>
