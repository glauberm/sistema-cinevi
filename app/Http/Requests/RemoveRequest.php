<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class RemoveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('hasRole', 'admin') === true;
    }

    /**
     * @inheritDoc
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para remover itens.');
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
