<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,string[]>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:180'],
            'identifier' => [
                'required',
                'numeric',
                'unique:users,identifier',
                'min_digits:7',
                'max_digits:9',
            ],
            'phone' => [
                'required',
                'numeric',
                'min_digits:10',
                'max_digits:11',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:180',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:12',
                'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
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
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome deve ter no máximo 180 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.string' => 'O email deve ser uma string.',
            'email.email' => 'O endereço de email não é válido.',
            'email.max' => 'O email deve ter no máximo 180 caracteres.',
            'email.unique' => 'Esse email já está em uso por outro usuário.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'password.min' => 'A senha deve ter no mínimo 12 caracteres.',
            'password.confirmed' => 'As senhas informadas não coincidem.',
            'password.regex' => 'A senha deve conter letras maiúsculas, minúsculas e números.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.numeric' => 'O telefone deve conter apenas números.',
            'phone.min' => 'O telefone deve ter no mínimo 10 dígitos, com DDD.',
            'phone.max' => 'O telefone deve ter no máximo 11 dígitos, com DDD.',
            'identifier.required' => 'A matrícula ou SIAPE é obrigatória.',
            'identifier.numeric' => 'A matrícula ou SIAPE deve conter apenas números.',
            'identifier.min_digits' => 'A matrícula ou SIAPE deve ter no mínimo 7 dígitos.',
            'identifier.max_digits' => 'A matrícula ou SIAPE deve ter no máximo 9 dígitos.',
            'identifier.unique' => 'Essa matrícula ou SIAPE já está em uso.',
        ];
    }
}
