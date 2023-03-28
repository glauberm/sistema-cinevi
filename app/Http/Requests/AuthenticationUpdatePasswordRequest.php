<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationUpdatePasswordRequest extends FormRequest
{
    /**
     * @return array<string,string[]>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'current_password'],
            'new_password' => [
                'required',
                'string',
                'min:12',
                'confirmed',
                'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
            ],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'password.current_password' => 'A senha informada está incorreta.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.string' => 'A nova senha deve ser uma string.',
            'new_password.min' => 'A nova senha deve ter no mínimo 12 caracteres.',
            'new_password.confirmed' => 'As senhas informadas não coincidem.',
            'new_password.regex' => 'A senha deve conter letras maiúsculas, minúsculas e números.',
        ];
    }
}
