<?php
namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ActivityTypeEnum extends Enum
{
    const Login = 0;
    const PasswordChange = 1;
    const EmailChange = 2;

    public static function getDescription(mixed $value): string
    {
        return match($value){
            self::Login => 'User login found',
            self::PasswordChange => 'User changed password',
            self::EmailChange => 'User changed email',
            // default => 'Unknown activity type',
        };
    }

    public static function keyAsdescription(mixed $value)
    {
        return match($value){
            self::Login => ''
        }
    }
}
