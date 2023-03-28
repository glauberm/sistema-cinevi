<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Services\FinalCopyService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class FinalCopyRemoveRequest extends FormRequest
{
    public function authorize(FinalCopyService $service): bool
    {
        if ($id = $this->route('id')) {
            $finalCopy = $service->get(\intval($id), ['owner']);

            return Gate::allows('hasRole', UserRole::Admin) === true ||
                Gate::allows('hasRole', UserRole::Department) === true ||
                Gate::allows('isUser', $finalCopy->owner_id);
        }

        return false;
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para remover esta cópia final.'
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
