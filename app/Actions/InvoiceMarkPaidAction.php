<?php

declare(strict_types=1);

namespace App\Actions;

use App\Entities\Invoice;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

final class InvoiceMarkPaidAction
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    /**
     * @param int $invoiceId
     *
     * @return void
     * @throws EntityNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function __invoke(int $invoiceId): void
    {
        $invoice = $this->entityManager->find(Invoice::class, $invoiceId) ?? throw new EntityNotFoundException(
            "Invoice $invoiceId not found"
        );

        $invoice->markAsPaid();
        $this->entityManager->flush();
    }
}
