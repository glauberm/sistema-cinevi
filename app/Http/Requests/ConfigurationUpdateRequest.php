<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ConfigurationUpdateRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('hasRole', UserRole::Admin);
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para editar as configurações.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,string[]>
     */
    public function rules()
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
     * Get the error messages for the defined validation rules.
     *
     * @return array<string,string>
     */
    public function messages()
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
