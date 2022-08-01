<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AuthenticationUpdatePasswordRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        if ($user === null) {
            throw new AuthorizationException('O usuário não foi encontrado.');
        }

        return Auth::attempt([
            'email' => $user->email,
            'password' => $this->input('password'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string[]>
     */
    public function rules()
    {
        return [
            'password' => ['required', 'string'],
            'new_password' => [
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
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.string' => 'A nova senha deve ser uma string.',
            'new_password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
            'new_password.confirmed' => 'As senhas informadas não coincidem.',
            'new_password.regex' => 'A nova senha deve conter letras maiúsculas e minúsculas, números e símbolos (!@#$%).',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('A senha atual informada está incorreta.');
    }
}
