<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceFormRequest;
use App\Services\InvoiceServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceServices $invoiceServices
    ) {
    }

    public function issue(InvoiceFormRequest $request): JsonResponse
    {
        $invoice = $this->invoiceServices->createIssue($request->validated())->json();

        return response()->json(
            $invoice,
            Response::HTTP_OK
        );
    }

    public function consult(string $key): JsonResponse
    {
        $invoice = $this->invoiceServices->consult(key: $key)->json();

        return response()->json(
            $invoice,
            Response::HTTP_OK
        );
    }

    public function cancel(InvoiceFormRequest $request): JsonResponse
    {
        $invoice = $this->invoiceServices->cancel($request->validated())->json();

        return response()->json(
            $invoice,
            Response::HTTP_OK
        );
    }

    public function certificate(): JsonResponse
    {
        $invoice = $this->invoiceServices->certificate()->json();

        return response()->json(
            $invoice,
            Response::HTTP_OK
        );
    }

    public function sefaz(): JsonResponse
    {
        $invoice = $this->invoiceServices->getSefaz()->json();

        return response()->json(
            $invoice,
            Response::HTTP_OK
        );
    }
}
