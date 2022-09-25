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
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(ProjectService $service)
    {
        if ($id = $this->route('id')) {
            $project = $service->get(\intval($id));

            return Gate::allows('hasRole', UserRole::Admin) ||
                Gate::allows('hasRole', UserRole::Department) ||
                Gate::allows('isUser', $project->owner_id);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Você não tem permissão para remover este projeto.');
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
