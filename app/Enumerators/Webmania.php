<?php

declare(strict_types=1);

namespace App\Enumerators;

enum Webmania: string
{
    case V1 = '1';
    case NFE = 'nfe';
    case CONFIG_FILE = 'integrations';
    case WEBMANIA = 'webmania';

    public static function getApiBaseURL(): string
    {
        return config(
            self::CONFIG_FILE->value . '.' . self::WEBMANIA->value . '.' . Domain::API->value,
            ''
        );
    }

    public static function getApiURI(): string
    {
        return self::getApiBaseURL() . self::V1->value . '/' . self::NFE->value . '/';
    }

    public static function getHeaders(): array
    {
        return config(
            self::CONFIG_FILE->value . '.' . self::WEBMANIA->value . '.' . Domain::CREDENTIALS->value,
            []
        );
    }
}
