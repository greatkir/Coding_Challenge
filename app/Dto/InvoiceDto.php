<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

final class InvoiceDto extends Data
{
    public int $creditorId;

    public int $debtorId;

    #[MapInputName('cost')]
    public int $costInCoins;

    public string $currency;

    public string $details;
}
