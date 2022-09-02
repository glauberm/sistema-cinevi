<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class UserRemoveRequest extends RemoveRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('hasRole', 'admin') === true && Gate::allows('isNotUser', $this->route('id')) === true;
    }

    /**
     * @inheritDoc
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para remover este usuário.');
    }
}
