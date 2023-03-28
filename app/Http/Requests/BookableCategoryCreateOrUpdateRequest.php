<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BookableCategoryCreateOrUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('hasRole', UserRole::Admin)
            || Gate::allows('hasRole', UserRole::Warehouse);
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para criar ou editar categorias de
            reserváveis.'
        );
    }

    /**
     * @return array<string,string[]>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['string', 'nullable'],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O nome é obrigatório.',
            'title.string' => 'O nome deve ser uma string.',
            'description.string' => 'A descrição deve ser uma string.',
        ];
    }
}
