<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProductionRoleRemoveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('hasRole', UserRole::Admin)
            || Gate::allows('hasRole', UserRole::Department);
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para remover funções.'
        );
    }

    /**
     * @return array<void>
     */
    public function rules(): array
    {
        return [];
    }
}
