<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\InvoiceCreateAction;
use App\Dto\InvoiceDto;
use App\Http\Requests\InvoiceCreateRequest;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class InvoiceCreateController
{
    #[OA\Post(
        path: '/api/v1/invoice',
        operationId: 'createInvoice',
        summary: 'Create a new invoice',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'creditorId',
                        title: 'Creditor ID',
                        type: 'int',
                    ),
                    new OA\Property(
                        property: 'debtorId',
                        title: 'Debtor ID',
                        type: 'int',
                    ),
                    new OA\Property(
                        property: 'cost',
                        title: 'Cost in coins',
                        type: 'int',
                    ),
                    new OA\Property(
                        property: 'currency',
                        title: 'Currency',
                        type: 'string',
                    ),
                    new OA\Property(
                        property: 'details',
                        title: 'Details of the invoice',
                        type: 'string',
                    ),
                ]
            ),
        ),
        tags: ['invoice'],
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: 'A new invoice was added',
                headers: [
                    new OA\Header(
                        header: 'Location',
                        description: 'Location of the created resource',
                        required: true,
                        schema: new OA\Schema(
                            properties: [
                                new OA\Property(
                                    property: 'Location',
                                    type: 'string',
                                ),
                            ]
                        )
                    ),
                ],
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Not found creditor or debtor company',
            ),
        ]
    )]
    public function __invoke(
        InvoiceCreateRequest $request,
        InvoiceCreateAction $createInvoice,
        ResponseFactory $responseFactory
    ) {
        try {
            $newInvoiceId = ($createInvoice)(InvoiceDto::from($request->validated()));

            return $responseFactory->make(['New invoice id' => $newInvoiceId], Response::HTTP_CREATED);
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
