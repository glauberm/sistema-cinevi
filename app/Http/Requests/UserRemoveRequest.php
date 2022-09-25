<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserRemoveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('hasRole', UserRole::Admin) && Gate::allows('isNotUser', $this->route('id'));
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para remover este usuário.');
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
