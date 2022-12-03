<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('hasRole', UserRole::Admin);
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para criar ou editar usuários.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,string[]>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:180'],
            'email' => ['required', 'string', 'email', 'max:180', "unique:users,email,{$this->route('id')}"],
            'phone' => [
                'required',
                'numeric',
                'min_digits:10',
                'max_digits:11',
            ],
            'identifier' => [
                'required',
                'string',
                "unique:users,identifier,{$this->route('id')}",
                'regex:/^[0-9]*$/',
            ],
            'is_confirmed' => ['required', 'boolean'],
            'roles' => ['array', 'required'],
            'roles.*' => ['string', 'required'],
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
            'phone.required' => 'O telefone é obrigatório.',
            'phone.numeric' => 'O telefone deve conter apenas números.',
            'phone.min_digits' => 'O telefone deve ter no mínimo 10 dígitos, com DDD.',
            'phone.max_digits' => 'O telefone deve ter no máximo 11 dígitos, com DDD.',
            'identifier.required' => 'A matrícula ou SIAPE é obrigatória.',
            'identifier.string' => 'A matrícula ou SIAPE deve ser uma string.',
            'identifier.unique' => 'Essa matrícula ou SIAPE já está em uso.',
            'is_confirmed.required' => 'Por favor, informe se o usuário está confirmado ou não.',
            'is_confirmed.boolean' => 'O dado se o usuário está confirmado ou não deve ser do tipo booleano.',
            'roles.array' => 'Os papéis devem ser um array.',
            'roles.required' => 'O usuário deve ter ao menos um papel no sistema.',
            'roles.*.string' => 'Cada papel deve ser uma string.',
            'roles.*.required' => 'O usuário deve ter ao menos um papel no sistema.',
        ];
    }
}
