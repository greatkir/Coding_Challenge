<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CompanyCreateAction;
use App\Dto\CompanyDto;
use App\Http\Requests\CompanyCreateRequest;
use Illuminate\Routing\ResponseFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[OA\Info(version: "0.1", title: "Billie Backend coding challenge API")]
final class CompanyCreateController
{
    #[OA\Post(
        path: '/api/v1/company',
        operationId: 'createCompany',
        summary: 'Create a new company',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'name',
                        title: 'Company name',
                        type: 'string',
                    ),
                    new OA\Property(
                        property: 'limit',
                        title: 'Debtor limit',
                        type: 'int',
                    ),
                ]
            ),
        ),
        tags: ['company'],
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: 'A new company was added',
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
        ]
    )]
    public function __invoke(CompanyCreateRequest $request, CompanyCreateAction $createCompany, ResponseFactory $responseFactory)
    {
        $newCompanyId = ($createCompany)(CompanyDto::from($request->validated()));

        return $responseFactory->make(['New company Id' => $newCompanyId]);
    }
}
