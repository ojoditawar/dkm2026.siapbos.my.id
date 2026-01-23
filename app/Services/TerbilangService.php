<?php

namespace App\Services;

class TerbilangService
{
    /**
     * Konversi angka ke terbilang bahasa Indonesia
     *
     * @param int|float $angka
     * @return string
     */
    public static function convert($angka)
    {
        $angka = abs($angka);
        $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $terbilang = "";

        if ($angka < 12) {
            $terbilang = " " . $baca[$angka];
        } else if ($angka < 20) {
            $terbilang = self::convert($angka - 10) . " Belas";
        } else if ($angka < 100) {
            $terbilang = self::convert($angka / 10) . " Puluh" . self::convert($angka % 10);
        } else if ($angka < 200) {
            $terbilang = " Seratus" . self::convert($angka - 100);
        } else if ($angka < 1000) {
            $terbilang = self::convert($angka / 100) . " Ratus" . self::convert($angka % 100);
        } else if ($angka < 2000) {
            $terbilang = " Seribu" . self::convert($angka - 1000);
        } else if ($angka < 1000000) {
            $terbilang = self::convert($angka / 1000) . " Ribu" . self::convert($angka % 1000);
        } else if ($angka < 1000000000) {
            $terbilang = self::convert($angka / 1000000) . " Juta" . self::convert($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $terbilang = self::convert($angka / 1000000000) . " Milyar" . self::convert($angka % 1000000000);
        } else if ($angka < 1000000000000000) {
            $terbilang = self::convert($angka / 1000000000000) . " Trilyun" . self::convert($angka % 1000000000000);
        }

        return trim($terbilang);
    }

    /**
     * Konversi angka ke terbilang dengan format mata uang Rupiah
     *
     * @param int|float $angka
     * @return string
     */
    public static function rupiah($angka)
    {
        if ($angka == 0) {
            return "Nol Rupiah";
        }

        $terbilang = self::convert($angka);
        return $terbilang . " Rupiah";
    }

    /**
     * Konversi angka ke terbilang dengan format mata uang dan sen
     *
     * @param float $angka
     * @return string
     */
    public static function rupiahWithSen($angka)
    {
        $rupiah = floor($angka);
        $sen = round(($angka - $rupiah) * 100);

        $result = self::convert($rupiah) . " Rupiah";

        if ($sen > 0) {
            $result .= " " . self::convert($sen) . " Sen";
        }

        return trim($result);
    }
}
