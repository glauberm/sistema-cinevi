<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string[]>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:180', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:180', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%]).*$/',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/\(\d{2}\)\s(\d{5}|\d{4})-\d{4}/',
            ],
            'identifier' => [
                'required',
                'string',
                'unique:users,identifier',
                'regex:/^[0-9]*$/',
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
            'phone.required' => 'O telefone é obrigatório.',
            'phone.string' => 'O telefone deve ser uma string.',
            'phone.regex' => 'O telefone pode estar nos seguintes formatos: (99) 9999-9999 ou (99) 99999-9999.',
            'identifier.required' => 'A matrícula ou SIAPE é obrigatório.',
            'identifier.string' => 'A matrícula ou SIAPE deve ser uma string.',
            'identifier.unique' => 'Essa matrícula ou SIAPE já está em uso.',
        ];
    }
}
