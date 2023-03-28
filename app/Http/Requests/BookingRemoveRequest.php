<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Services\BookingService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BookingRemoveRequest extends FormRequest
{
    public function authorize(BookingService $service): bool
    {
        if ($id = $this->route('id')) {
            $booking = $service->get(\intval($id), ['owner']);

            return Gate::allows('hasRole', UserRole::Admin) === true ||
                Gate::allows('hasRole', UserRole::Warehouse) === true ||
                Gate::allows('isUser', $booking->owner_id);
        }

        return false;
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para remover esta reserva.'
        );
    }

    /**
     * @return array<void>
     */
    public function rules(): array
    {
        return [];
    }
}
