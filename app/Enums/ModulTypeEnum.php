<?php

namespace App\Enums;

class ModulTypeEnum
{
    const HEADER = 0;
    const CONTENT = 1;

    public static function get(): array
    {
        return [
            self::HEADER => 'Modul Header',
            self::CONTENT => 'Modul Content',
        ];
    }
}
