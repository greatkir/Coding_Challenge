<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'invoices')]
#[HasLifecycleCallbacks]
class Invoice
{
    #[Id, GeneratedValue(strategy: "IDENTITY"), Column(type: "integer", unique: true, options: ['unsigned' => true])]
    protected readonly int $id;

    #[ManyToOne(targetEntity: Company::class)]
    protected readonly Company $creditor;

    #[ManyToOne(targetEntity: Company::class)]
    protected readonly Company $debtor;

    #[Embedded(class: Money::class)]
    protected Money $cost;

    #[Column(type: "string")]
    protected string $details;

    #[Column(type: "boolean")]
    protected bool $isPaid;

    public function __construct(
        Company $creditor,
        Company $debtor,
        string $details,
        int $costs,
        string $currency,
    ) {
        if ($debtor->remainingDebtorLimit() < $costs) {
            throw new \DomainException(
                'Unable to accept invoice because total amount of open invoices exceeds the limit'
            );
        }

        if ($creditor === $debtor) {
            throw new \DomainException(
                'It`s not possible to have the same company as debtor and creditor in the same time'
            );
        }
        $this->creditor = $creditor;
        $this->debtor = $debtor;
        $this->details = $details;
        $this->cost = new Money($costs, $currency);
        $this->isPaid = false;
    }

    #[PrePersist]
    public function increaseCompanyDebt()
    {
        $this->debtor->addToDebt($this->cost->coins);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function markAsPaid(): void
    {
        if ($this->isPaid) {
            throw new \DomainException("Invoice $this->id is already paid");
        }

        $this->debtor->addToDebt(-($this->cost->coins));
        $this->isPaid = true;
    }
}
