<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

final class CompanyDto extends Data
{
    #[MapInputName('name')]
    public string $companyName;

    #[MapInputName('limit')]
    public int $companyDebtorLimit;
}
