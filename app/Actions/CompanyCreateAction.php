<?php

declare(strict_types=1);

namespace App\Actions;

use App\Dto\CompanyDto;
use App\Entities\Company;
use Doctrine\ORM\EntityManager;

final class CompanyCreateAction
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function __invoke(CompanyDto $companyDto)
    {
        $company = new Company($companyDto->companyName, $companyDto->companyDebtorLimit);

        $this->entityManager->persist($company);
        $this->entityManager->flush();

        return $company->getId();
    }
}
