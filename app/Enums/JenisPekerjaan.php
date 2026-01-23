<?php

namespace App\Enums;

enum JenisPekerjaan: string
{
    case PNS = 'PNS';
    case SWASTA = 'Swasta';
    case WIRAUSAHA = 'Wirausaha';
    case PENSIUNAN = 'Pensiunan';
    case LAINNYA = 'Lainnya';

    public function getLabel(): string
    {
        return match ($this) {
            self::PNS => 'Pegawai Negeri Sipil (PNS)',
            self::SWASTA => 'Karyawan Swasta',
            self::WIRAUSAHA => 'Wirausaha/Pengusaha',
            self::PENSIUNAN => 'Pensiunan',
            self::LAINNYA => 'Lainnya',
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}
