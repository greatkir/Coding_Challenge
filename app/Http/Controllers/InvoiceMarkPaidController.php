<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\InvoiceMarkPaidAction;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class InvoiceMarkPaidController
{
    #[OA\Patch(
        path: '/api/v1/invoice/{id}/markPaid',
        operationId: 'markInvoicePaid',
        summary: 'Mark invoice as paid',
        tags: ['invoice'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Invoice marked as paid',
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Invoice not found',
            ),
        ]
    )]
    public function __invoke(int $invoiceId, InvoiceMarkPaidAction $markPaidAction, ResponseFactory $responseFactory)
    {
        try {
            ($markPaidAction)($invoiceId);

            return $responseFactory->make([], Response::HTTP_OK);
        } catch (EntityNotFoundException $exception) {
            return $responseFactory->make(['exception' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\DomainException $exception) {
            return $responseFactory->make(['exception' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $responseFactory->make(
                ['exception' => 'An error occurred', ['exception' => $exception]],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
