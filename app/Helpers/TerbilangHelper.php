<?php

use App\Services\TerbilangService;

if (!function_exists('terbilang')) {
    /**
     * Konversi angka ke terbilang bahasa Indonesia
     *
     * @param int|float $angka
     * @return string
     */
    function terbilang($angka)
    {
        return TerbilangService::convert($angka);
    }
}

if (!function_exists('terbilang_rupiah')) {
    /**
     * Konversi angka ke terbilang dengan format Rupiah
     *
     * @param int|float $angka
     * @return string
     */
    function terbilang_rupiah($angka)
    {
        return TerbilangService::rupiah($angka);
    }
}

if (!function_exists('terbilang_rupiah_sen')) {
    /**
     * Konversi angka ke terbilang dengan format Rupiah dan Sen
     *
     * @param float $angka
     * @return string
     */
    function terbilang_rupiah_sen($angka)
    {
        return TerbilangService::rupiahWithSen($angka);
    }
}
