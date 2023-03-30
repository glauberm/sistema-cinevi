<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BookableCreateOrUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('hasRole', UserRole::Admin)
            || Gate::allows('hasRole', UserRole::Warehouse);
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para criar ou editar reserváveis.'
        );
    }

    /**
     * @return array<string,string[]>
     */
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string'],
            'name' => ['required', 'string'],
            'inventory_number' => ['nullable', 'string'],
            'serial_number' => ['nullable', 'string'],
            'accessories' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'is_under_maintenance' => ['required', 'boolean'],
            'is_return_overdue' => ['required', 'boolean'],
            'bookable_category_id' => ['required', 'integer'],
            'users' => ['nullable', 'array'],
            'users.*.id' => ['nullable', 'integer'],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'identifier.required' => 'O código é obrigatório.',
            'identifier.string' => 'O código deve ser uma string.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'inventory_number.string' => 'O número de patrimônio deve ser uma string.',
            'serial_number.string' => 'O número de série deve ser uma string.',
            'accessories.string' => 'Os dados de acessórios devem estar em uma string.',
            'notes.string' => 'As observações devem ser uma string.',
            'is_under_maintenance.boolean' => 'A informação de se o reservável está em manutenção deve ser um valor booleano.',
            'is_under_maintenance.required' => 'Você deve informar se o reservável está em manutenção ou não.',
            'is_return_overdue.boolean' => 'A informação de se o reservável está com a devolução atrasada deve ser um valor booleano.',
            'is_return_overdue.required' => 'Você deve informar se o reservável está com a devolução atrasada ou não.',
            'bookable_category_id.required' => 'A categoria de reservável é obrigatória.',
            'bookable_category_id.string' => 'O identificador da categoria de reservável deve ser um inteiro.',
            'users.array' => 'Os dados dos únicos usuários que podem reservar este reservável deve estar em um array.',
            'users.*.id.integer' => 'Os identificadores dos únicos usuários que podem reservar este reservável devem ser um inteiro.',
        ];
    }
}
