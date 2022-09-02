<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationResetPasswordRequest extends FormRequest
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
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%]).*$/',
            ],
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
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas informadas não coincidem.',
            'password.regex' => 'A senha informada é muito fraca. Use letras maiúsculas e minúsculas, números e símbolos (!@#$%).',
        ];
    }
}
