<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\InvoiceRepository;
use Illuminate\Http\Client\Response;

class InvoiceServices
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository
    ) {
    }

    public function createIssue(array $attributes): Response
    {
        return $this->invoiceRepository->createIssue(attributes: $attributes);
    }

    public function consult(string $key): Response
    {
        return $this->invoiceRepository->consult(key: $key);
    }

    public function cancel(array $attributes): Response
    {
        return $this->invoiceRepository->cancel(attributes: $attributes);
    }

    public function certificate(): Response
    {
        return $this->invoiceRepository->certificate();
    }

    public function getSefaz(): Response
    {
        return $this->invoiceRepository->getSefaz();
    }
}
