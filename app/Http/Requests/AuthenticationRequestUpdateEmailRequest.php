<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Services\AuthService;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequestUpdateEmailRequest extends FormRequest
{
    /**
     * @return array<string,string[]>
     */
    public function rules(AuthService $authService): array
    {
        $authId = $authService->getAuthIdOrFail();

        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:180',
                'confirmed',
                'unique:users,email,' . $authId,
            ],
            'password' => ['required', 'string', 'current_password'],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O email é obrigatório.',
            'email.string' => 'O email deve ser uma string.',
            'email.email' => 'O endereço de email não é válido.',
            'email.max' => 'O email deve ter no máximo 180 caracteres.',
            'email.unique' => 'Esse email já está em uso por outro usuário.',
            'email.confirmed' => 'Os emails informados não coincidem.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'password.current_password' => 'A senha informada está incorreta.',
        ];
    }
}
