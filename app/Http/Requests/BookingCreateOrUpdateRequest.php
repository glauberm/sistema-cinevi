<?php

namespace App\Http\Requests;

use App\Rules\BookingIsNotForbiddenDateRule;
use App\Rules\BookingIsNotWeekendRule;
use App\Rules\BookingsAreClosedRule;
use App\Services\ConfigurationService;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BookingCreateOrUpdateRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $owner = $this->input('owner');

        $project = $this->input('project');

        if (!\is_array($owner) || !\array_key_exists('id', $owner)) {
            throw new BadRequestHttpException('Os dados do responsável pela reserva estão em um formato inválido.');
        }

        if (!\is_array($project) || !\array_key_exists('id', $project)) {
            throw new BadRequestHttpException('Os dados do projeto associado à estão em um formato inválido.');
        }

        $this->merge(['owner_id' => $owner['id']]);

        $this->merge(['project_id' => $project['id']]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,mixed[]>
     */
    public function rules(ConfigurationService $configurationService)
    {
        return [
            'owner_id' => [
                'integer',
                'required',
                new BookingsAreClosedRule($configurationService)
            ],
            'project_id' => ['integer', 'required'],
            'withdrawal_date' => [
                'string',
                'required',
                'date_format:Y-m-d',
                'after:today+2days',
                new BookingIsNotWeekendRule(),
                new BookingIsNotForbiddenDateRule($configurationService),
            ],
            'devolution_date' => [
                'string',
                'required',
                'date_format:Y-m-d',
                'after_or_equal:withdrawal_date',
                new BookingIsNotWeekendRule(),
                new BookingIsNotForbiddenDateRule($configurationService),
            ],
            'bookables' => ['array', 'required'],
            'bookables.*.id' => ['integer', 'required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string,string>
     */
    public function messages()
    {
        $dateFormat = CarbonImmutable::now()->format('Y-m-d');

        return [
            'owner_id.integer' => 'É obrigatório informar a pessoa responsável pela reserva.',
            'owner_id.required' => 'É obrigatório informar a pessoa responsável pela reserva.',
            'project_id.integer' => 'O formato do projeto associado à reserva está incorreto.',
            'project_id.required' => 'É obrigatório informar o projeto associado à reserva.',
            'withdrawal_date.string' => 'O formato da data de retirada está incorreto.',
            'withdrawal_date.required' => 'A data de retirada é obrigatória.',
            'withdrawal_date.date_format' => "A data de retirada deve estar no seguinte formato: {$dateFormat}",
            'withdrawal_date.after' => 'As reservas precisam ser feitas ou editadas com antecedência mínima de 3 dias.',
            'devolution_date.string' => 'O formato da data de devolução está incorreto.',
            'devolution_date.required' => 'A data de devolução é obrigatória.',
            'devolution_date.date_format' => "A data de devolução deve estar no seguinte formato: {$dateFormat}",
            'devolution_date.after_or_equal' => 'As devoluções precisam ser feitas no dia da retirada ou após.',
            'bookables.array' => 'O formato dos reserváveis está incorreto.',
            'bookables.required' => 'É obrigatório informar os reserváveis associados à reserva.',
            'bookables.*.id.integer' => 'O formato dos reserváveis está incorreto.',
            'bookables.*.id.required' => 'É obrigatório informar os reserváveis associados à reserva.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string,string>
     */
    public function attributes()
    {
        return [
            'withdrawal_date' => 'data de retirada',
            'devolution_date' => 'data de devolução',
        ];
    }
}
