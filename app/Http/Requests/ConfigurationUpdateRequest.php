<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationUpdateRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'bookings_create_or_update_emails' => ['nullable', 'array'],
            'bookings_create_or_update_emails.*' => ['nullable', 'string', 'email'],
            'final_copies_confirmation_message' => ['required', 'string'],
            'final_copies_create_emails' => ['nullable', 'array'],
            'final_copies_confirmed_emails.*' => ['nullable', 'string', 'email'],
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
            'bookings_create_or_update_emails.array' => 'O emails notificados pelas reservas devem estar em um array',
            'bookings_create_or_update_emails.*.string' => 'Os emails notificados pelas reservas devem ser strings',
            'bookings_create_or_update_emails.*.email' => 'Os emails notificados pelas reservas estão em um formato inválido',
            'final_copies_confirmation_message.required' => 'A mensagem das cópias finais é obrigatória',
            'final_copies_confirmation_message.string' => 'A mensagem das cópias finais deve ser uma string',
            'final_copies_create_emails.array' => 'O emails notificados pela criação das cópias finais devem estar em um array',
            'final_copies_create_emails.*.string' => 'O emails notificados pela criação das cópias finais devem ser strings',
            'final_copies_create_emails.*.email' => 'Os emails notificados pela criação das cópias finais estão em um formato inválido',
            'final_copies_confirmed_emails.array' => 'O emails notificados pela criação das cópias finais devem estar em um array',
            'final_copies_confirmed_emails.*.string' => 'O emails notificados pela confirmação das cópias finais devem ser strings',
            'final_copies_confirmed_emails.*.email' => 'Os emails notificados pela confirmação das cópias finais estão em um formato inválido',
        ];
    }
}
