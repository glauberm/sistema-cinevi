<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationRequestUpdateEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $currentUser = $this->user();

        if (\is_null($currentUser)) {
            return false;
        }

        /** @var string $password */
        $password = $this->input('password');

        return Hash::check($password, $currentUser->password);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string[]>
     */
    public function rules()
    {
        $user = Auth::user();

        if ($user === null) {
            throw new AuthorizationException('O usuário não foi encontrado.');
        }

        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:180',
                'confirmed',
                'unique:users,email,'.$user->id,
            ],
            'password' => ['required', 'string', 'min:8'],
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
            'email.confirmed' => 'Os e-mails informados não coincidem.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser uma string.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('A senha informada está incorreta.');
    }
}
