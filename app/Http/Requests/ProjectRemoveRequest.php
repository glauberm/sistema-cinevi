<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Services\ProjectService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProjectRemoveRequest extends FormRequest
{
    public function authorize(ProjectService $service): bool
    {
        if ($id = $this->route('id')) {
            $project = $service->get(intval($id), ['owner']);

            return Gate::allows('hasRole', UserRole::Admin)
                || Gate::allows('hasRole', UserRole::Department)
                || Gate::allows('isUser', $project->owner_id);
        }

        return false;
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para remover este projeto.'
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
