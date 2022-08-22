<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * InvoiceCreateRequest
 *
 * @copyright DevelopmentAid
 */
final class InvoiceCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'creditorId' => ['integer', 'min:1'],
            'debtorId' => ['integer', 'min:1'],
            'cost' => ['integer', 'min:1'],
            'currency' => ['string', 'max:10'],
            'details' => ['string'],
        ];
    }
}
