<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BookableCreateOrUpdateRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('hasRole', UserRole::Admin) || Gate::allows('hasRole', UserRole::Warehouse);
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para criar ou editar reserváveis.');
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $bookableCategory = $this->input('bookable_category');

        if (! \is_array($bookableCategory) || ! \array_key_exists('id', $bookableCategory)) {
            throw new BadRequestHttpException('Os dados da categoria de reservável estão em um formato inválido.');
        }

        $this->merge(['bookable_category_id' => $bookableCategory['id']]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,string[]>
     */
    public function rules()
    {
        return [
            'identifier' => ['required', 'string'],
            'name' => ['required', 'string'],
            'inventory_number' => ['nullable', 'string'],
            'serial_number' => ['nullable', 'string'],
            'accessories' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'is_under_maintenance' => ['required', 'boolean'],
            'is_return_overdue' => ['required', 'boolean'],
            'bookable_category_id' => ['required', 'integer'],
            'users' => ['nullable', 'array'],
            'users.*.id' => ['nullable', 'integer'],
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
            'identifier.required' => 'O código é obrigatório.',
            'identifier.string' => 'O código deve ser uma string.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'inventory_number.string' => 'O número de patrimônio deve ser uma string.',
            'serial_number.string' => 'O número de série deve ser uma string.',
            'accessories.string' => 'Os dados de acessórios devem estar em uma string.',
            'notes.string' => 'As observações devem ser uma string.',
            'is_under_maintenance.boolean' => 'A informação de se o reservável está em manutenção deve ser um valor booleano.',
            'is_under_maintenance.required' => 'Você deve informar se o reservável está em manutenção ou não.',
            'is_return_overdue.boolean' => 'A informação de se o reservável está com a devolução atrasada deve ser um valor booleano.',
            'is_return_overdue.required' => 'Você deve informar se o reservável está com a devolução atrasada ou não.',
            'bookable_category_id.required' => 'A categoria de reservável é obrigatória.',
            'bookable_category_id.string' => 'O identificador da categoria de reservável deve ser um inteiro.',
            'users.array' => 'Os dados dos únicos usuários que podem reservar este reservável deve estar em um array.',
            'users.*.id.integer' => 'Os identificadores dos únicos usuários que podem reservar este reservável devem ser um inteiro.',
        ];
    }
}
