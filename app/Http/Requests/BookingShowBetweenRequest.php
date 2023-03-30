<?php

namespace App\Http\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class BookingShowBetweenRequest extends FormRequest
{
    /**
     * @return array<string,string[]>
     */
    public function rules(): array
    {
        return [
            'start_date' => ['string', 'required', 'date_format:Y-m-d'],
            'end_date' => ['string', 'required', 'date_format:Y-m-d'],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        $dateFormat = CarbonImmutable::now()->format('Y-m-d');

        return [
            'start_date.string' => 'O formato da data inicial está incorreto.',
            'start_date.required' => 'A data inicial é obrigatória.',
            'start_date.date_format' => "A data inicial deve estar no seguinte formato: {$dateFormat}",
            'end_date.string' => 'O formato da data final está incorreto.',
            'end_date.required' => 'A data final é obrigatória.',
            'end_date.date_format' => "A data final deve estar no seguinte formato: {$dateFormat}",
        ];
    }
}