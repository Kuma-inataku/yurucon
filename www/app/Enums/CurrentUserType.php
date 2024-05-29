<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Counselor()
 * @method static static Client()
 */
final class CurrentUserType extends Enum
{
    public const Counselor = 1;
    public const Client = 2;
}
