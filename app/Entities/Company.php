<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'companies')]
class Company
{
    #[Id, GeneratedValue(strategy: "IDENTITY"), Column(type: "integer", unique: true, options: ['unsigned' => true])]
    protected readonly int $id;

    #[Column(type: "string", length: 250)]
    protected string $name;

    #[Column(type: "integer", name: "debtor_limit")]
    protected int $debtorLimit;

    public function __construct(string $name, int $companyDebtorLimit)
    {
        $this->name = $name;
        $this->debtorLimit = $companyDebtorLimit;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
