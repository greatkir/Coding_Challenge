<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CompanyCreateRequest
 *
 * @copyright DevelopmentAid
 */
final class CompanyCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'limit' => ['required', 'numeric', 'min:0'],
        ];
    }
}
