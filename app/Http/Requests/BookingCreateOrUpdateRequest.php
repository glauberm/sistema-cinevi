<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Rules\BookableIsNotReservedRule;
use App\Rules\BookingIsNotForbiddenDateRule;
use App\Rules\BookingIsNotWeekendRule;
use App\Rules\BookingsAreClosedRule;
use App\Rules\UserIsSelf;
use App\Rules\UserOwnsProject;
use App\Services\AuthService;
use App\Services\BookableService;
use App\Services\BookingService;
use App\Services\ConfigurationService;
use App\Services\ProjectService;
use App\Services\UserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BookingCreateOrUpdateRequest extends FormRequest
{
    public function authorize(BookingService $service): bool
    {
        if ($id = $this->route('id')) {
            $booking = $service->get(intval($id), ['owner']);

            return Gate::allows('hasRole', UserRole::Admin)
                || Gate::allows('hasRole', UserRole::Warehouse)
                || Gate::allows('isUser', $booking->owner_id);
        }

        return true;
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para editar esta reserva.'
        );
    }

    /**
     * @return array<string,mixed[]>
     */
    public function rules(
        ConfigurationService $configurationService,
        AuthService $authService,
        UserService $userService,
        ProjectService $projectService,
        BookableService $bookableService
    ): array {
        $ownerIdRules = [
            'integer', 'required', new UserIsSelf($authService, $userService)
        ];

        if ($this->route('id')) {
            $ownerIdRules[] = new BookingsAreClosedRule(
                $configurationService,
                $authService,
                $userService
            );
        }

        return [
            'owner_id' => $ownerIdRules,
            'project_id' => [
                'integer',
                'required',
                new UserOwnsProject(
                    $authService,
                    $userService,
                    $projectService
                ),
            ],
            'withdrawal_date' => [
                'string',
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today+3days',
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
            'bookables.*.id' => [
                'integer',
                'required',
                new BookableIsNotReservedRule($bookableService),
            ],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
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
            'withdrawal_date.after_or_equal' => 'As reservas precisam ser feitas ou editadas com antecedência mínima de 3 dias.',
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
     * @return array<string,string>
     */
    public function attributes(): array
    {
        return [
            'owner_id' => 'responsável pela reserva',
            'project_id' => 'projeto associado à reserva',
            'withdrawal_date' => 'data de retirada',
            'devolution_date' => 'data de devolução',
        ];
    }
}
