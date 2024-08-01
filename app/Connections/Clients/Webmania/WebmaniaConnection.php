<?php

declare(strict_types=1);

namespace App\Connections\Clients\Webmania;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WebmaniaConnection
{
    /** @throws RequestException */
    public static function getIssueInvoice(): Response
    {
        return Http::post(Routes::ISSUE)->throw();
    }
}
