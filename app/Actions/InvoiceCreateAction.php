<?php

declare(strict_types=1);

namespace App\Actions;

use App\Dto\InvoiceDto;
use App\Entities\Company;
use App\Entities\Invoice;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

/**
 * InvoiceCreateAction
 *
 * @copyright DevelopmentAid
 */
final class InvoiceCreateAction
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    /**
     * @param InvoiceDto $invoiceDto
     *
     * @return int
     * @throws EntityNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function __invoke(InvoiceDto $invoiceDto): int
    {
        $invoice = new Invoice(
            $this->findCompany($invoiceDto->creditorId),
            $this->findCompany($invoiceDto->debtorId),
            $invoiceDto->details,
            $invoiceDto->costInCoins,
            $invoiceDto->currency
        );

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        return $invoice->getId();
    }

    /**
     * @param int $companyId
     *
     * @return Company
     * @throws EntityNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    private function findCompany(int $companyId): Company
    {
        return $this->entityManager->find(Company::class, $companyId) ?? throw new EntityNotFoundException(
            "Not found company with id $companyId"
        );
    }
}
