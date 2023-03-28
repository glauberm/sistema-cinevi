<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationResetPasswordRequest extends FormRequest
{
    /**
     * @return array<string,string[]>
     */
    public function rules(): array
    {
        return [
            'password' => [
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
            'password.min' => 'A senha deve ter no mínimo 12 caracteres.',
            'password.confirmed' => 'As senhas informadas não coincidem.',
            'password.regex' => 'A senha deve conter letras maiúsculas, minúsculas e números.',
        ];
    }
}
