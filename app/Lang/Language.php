<?php

namespace App\Lang;

enum Language: string
{
    case EN = "en";
    case MM = "mm";

    public function label()
    {
        return match ($this) {
            self::EN => 'English',
            self::MM => 'Myanmar',
        };
    }
}
