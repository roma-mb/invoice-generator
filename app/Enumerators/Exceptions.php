<?php

declare(strict_types=1);

namespace App\Enumerators;

enum Exceptions: string
{
    case NOT_FOUND = 'notFound';
    case UNAUTHORIZED = 'unauthorized';
}
