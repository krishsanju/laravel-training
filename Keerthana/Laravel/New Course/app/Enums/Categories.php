<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Categories extends Enum
{
    const GENERAL = 0;
    const WORLD = 1;
    const NATION = 2;
    const BUSINESS = 3;
    const TECHNOLOGY = 4;
    const ENTERTAINMENT = 5;
    const SPORTS = 6;
    const SCIENCE = 7;
    const HEALTH = 8;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::GENERAL => 'General',
            self::WORLD => 'World',
            self::NATION => 'Nation',
            self::BUSINESS => 'Business',
            self::TECHNOLOGY => 'Technology',
            self::ENTERTAINMENT => 'Entertainment',
            self::SPORTS => 'Sports',
            self::SCIENCE => 'Science',
            self::HEALTH => 'Health',
            default => self::getKey($value),
        };
    }
}
