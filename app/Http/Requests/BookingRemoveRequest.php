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
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(BookingService $service)
    {
        if ($id = $this->route('id')) {
            $booking = $service->get(\intval($id), ['owner']);

            return Gate::allows('hasRole', UserRole::Admin) === true ||
                Gate::allows('hasRole', UserRole::Warehouse) === true ||
                Gate::allows('isUser', $booking->owner_id);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para remover esta reserva.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<void>
     */
    public function rules()
    {
        return [];
    }
}
