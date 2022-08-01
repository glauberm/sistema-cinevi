<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateOrUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string[]>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:180', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:180', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%]).*$/',
            ],
            'phone' => ['required', 'string', 'max:180'],
            'identifier' => ['required', 'string', 'max:180', 'unique:users,identifier'],
            'is_confirmed' => ['required', 'boolean'],
            'is_professor' => ['required', 'boolean'],
            'roles' => ['array', 'required'],
            'roles.*' => ['string', 'required'],
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser uma string.',
            'email.email' => 'O endereço de e-mail não é válido.',
            'email.max' => 'O e-mail deve ter no máximo 180 caracteres.',
            'email.unique' => 'Esse e-mail já está em uso por outro usuário.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas informadas não coincidem.',
            'password.regex' => 'A senha deve conter maiúsculas e minúsculas, números e símbolos (!@#$%).',
            'roles.array' => 'Os papéis devem ser um array.',
            'roles.required' => 'O usuário deve ter ao menos um papel.',
            'roles.*.string' => 'Cada papel deve ser uma string.',
            'roles.*.required' => 'O usuário deve ter ao menos um papel.',
        ];
    }
}
