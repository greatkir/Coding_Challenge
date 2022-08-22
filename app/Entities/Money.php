<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Money
{
    #[Column(type: 'integer')]
    public readonly int $coins;

    #[Column(type: 'string')]
    public readonly string $currency;

    public function __construct(int $coins, string $currency)
    {
        $this->coins = $coins;
        $this->currency = $currency;
    }
}
