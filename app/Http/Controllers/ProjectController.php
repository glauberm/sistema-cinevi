<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProjectCreateOrUpdateRequest;
use App\Http\Requests\ProjectRemoveRequest;
use App\Mail\ProjectCreatedMail;
use App\Models\Project as ProjectModel;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $paginateRoute = 'project.index';

    protected string $paginateView = 'pages/project/index';

    protected string $paginateVersionsView = 'pages/project/versions-index';

    protected string $showVersionView = 'pages/project/version';

    public function __construct(
        protected readonly ProjectService $service,
        protected readonly UserService $userService
    ) {
        $this->middleware(Authenticate::class);
    }

    public function create(ProjectCreateOrUpdateRequest $request): RedirectResponse
    {
        return $this->doCreate($request);
    }

    public function update(ProjectCreateOrUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(ProjectRemoveRequest $request, int $id): RedirectResponse
    {
        return $this->doRemove($request, $id);
    }

    protected function afterCreated(ProjectCreateOrUpdateRequest $request, ProjectModel $project): void
    {
        $departmentUsers = $this->userService
            ->getAllWithRole(UserRole::Department);

        $warehouseUsers = $this->userService
            ->getAllWithRole(UserRole::Warehouse);

        Mail::to($project->professor->email)
            ->queue(new ProjectCreatedMail($project));

        foreach ($project->directors as $user) {
            Mail::to($user->email)
                ->queue(new ProjectCreatedMail($project));
        }

        foreach ($project->producers as $user) {
            Mail::to($user->email)
                ->queue(new ProjectCreatedMail($project));
        }

        foreach ($project->photographyDirectors as $user) {
            Mail::to($user->email)
                ->queue(new ProjectCreatedMail($project));
        }

        foreach ($project->soundDirectors as $user) {
            Mail::to($user->email)
                ->queue(new ProjectCreatedMail($project));
        }

        foreach ($project->artDirectors as $user) {
            Mail::to($user->email)
                ->queue(new ProjectCreatedMail($project));
        }

        foreach ($departmentUsers as $user) {
            Mail::to($user->email)
                ->queue(new ProjectCreatedMail($project));
        }

        foreach ($warehouseUsers as $user) {
            Mail::to($user->email)
                ->queue(new ProjectCreatedMail($project));
        }
    }
}