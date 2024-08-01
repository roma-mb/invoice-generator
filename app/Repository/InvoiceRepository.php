<?php

declare(strict_types=1);

namespace App\Repository;

use App\Connections\Clients\Webmania\Routes;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class InvoiceRepository
{
    public function createIssue(array $attributes): Response
    {
        return Http::webmania()->post(Routes::ISSUE, $attributes);
    }

    public function consult(string $key): Response
    {
        return Http::webmania()->get(Routes::CONSULT, [
            'key' => $key
        ]);
    }

    public function cancel(array $attributes): Response
    {
        return Http::webmania()->put(Routes::CANCEL, $attributes);
    }

    public function certificate(): Response
    {
        return Http::webmania()->get(Routes::CERTIFICATE);
    }

    public function getSefaz(): Response
    {
        return Http::webmania()->get(Routes::SEFAZ);
    }
}
