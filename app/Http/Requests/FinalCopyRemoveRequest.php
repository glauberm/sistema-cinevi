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
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(FinalCopyService $service)
    {
        if ($id = $this->route('id')) {
            $finalCopy = $service->get(\intval($id));

            return Gate::allows('hasRole', UserRole::Admin) === true ||
                Gate::allows('hasRole', UserRole::Department) === true ||
                Gate::allows('isUser', $finalCopy->owner_id);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para remover esta cópia final.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<void>
     */
    public function rules()
    {
        return [];
    }
}
