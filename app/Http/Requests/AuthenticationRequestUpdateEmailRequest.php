<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Services\AuthService;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequestUpdateEmailRequest extends FormRequest
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
    public function rules(AuthService $authService)
    {
        $authId = $authService->getAuthIdOrFail();

        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:180',
                'confirmed',
                'unique:users,email,'.$authId,
            ],
            'password' => ['required', 'string', 'min:8', 'current_password'],
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
            'email.required' => 'O email é obrigatório.',
            'email.string' => 'O email deve ser uma string.',
            'email.email' => 'O endereço de email não é válido.',
            'email.max' => 'O email deve ter no máximo 180 caracteres.',
            'email.unique' => 'Esse email já está em uso por outro usuário.',
            'email.confirmed' => 'Os emails informados não coincidem.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.current_password' => 'A senha informada está incorreta.',
        ];
    }
}
