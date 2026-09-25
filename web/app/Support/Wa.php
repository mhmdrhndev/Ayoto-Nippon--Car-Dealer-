<?php

namespace App\Support;

class Wa
{
    public static function nomor(string $telp): string
    {
        $angka = preg_replace('/[^0-9]/', '', $telp);
        if (str_starts_with($angka, '0')) {
            return '62'.substr($angka, 1);
        }

        return $angka;
    }

    public static function chat(string $telp, string $pesan): string
    {
        return 'https://wa.me/'.self::nomor($telp).'?text='.rawurlencode($pesan);
    }
}
