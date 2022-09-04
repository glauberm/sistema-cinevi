<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequestResetPasswordRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
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
            'email.email' => 'O email não é válido.',
        ];
    }
}
