<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionCategoryCreateOrUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string[]>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['string', 'nullable'],
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
            'title.required' => 'O nome é obrigatório.',
            'title.string' => 'O nome deve ser uma string.',
            'description.string' => 'A descrição deve ser uma string.',
        ];
    }
}
