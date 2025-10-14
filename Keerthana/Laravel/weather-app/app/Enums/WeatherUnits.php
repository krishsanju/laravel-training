<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WeatherUnits extends Enum
{
    public const Standard = 0;
    public const Metric = 1;
    public const Imperial = 2;

    public static function getDescription(mixed $value): string
    {
        return match($value){
            self::Standard => "standard",
            self::Metric => "metric",
            self:: Imperial => "imperial",
            default => parent::getDescription($value),
        };
    }
}
