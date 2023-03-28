<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ConfigurationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('hasRole', UserRole::Admin);
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para editar as configurações.'
        );
    }

    /**
     * @return array<string,string[]>
     */
    public function rules(): array
    {
        return [
            'bookings_are_closed' => ['required', 'boolean'],
            'bookings_forbidden_dates' => ['nullable', 'array'],
            'bookings_forbidden_dates.*.month' => ['nullable', 'string'],
            'bookings_forbidden_dates.*.day' => ['nullable', 'string'],
            'bookings_forbidden_dates.*.name' => ['nullable', 'string'],
            'final_copies_confirmation_message' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'bookings_are_closed.required' => 'Você deve informar se as reservas estão fechadas para os alunos ou não',
            'bookings_are_closed.boolean' => 'O campo das reservas fechadas é booleano',
            'bookings_forbidden_dates.array' => 'As datas proibidas deve estar em um array',
            'bookings_forbidden_dates.*.month.string' => 'Os meses das datas proibidas devem ser strings',
            'bookings_forbidden_dates.*.day.string' => 'Os dias das datas proibidas devem ser strings',
            'bookings_forbidden_dates.*.name.string' => 'Os nomes das datas proibidas devem ser strings',
            'final_copies_confirmation_message.required' => 'A mensagem das cópias finais é obrigatória',
            'final_copies_confirmation_message.string' => 'A mensagem das cópias finais deve ser uma string',
        ];
    }
}
