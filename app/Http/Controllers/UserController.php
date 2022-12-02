<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\UserRemoveRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User;
use App\Mail\UserIsConfirmedMail;
use App\Models\User as UserModel;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = User::class;

    public function __construct(protected readonly UserService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        /** @var UserModel $user */
        $user = $this->service->get($id, []);

        if (! $user->is_confirmed && $data['is_confirmed']) {
            Mail::to($user->email)->queue(new UserIsConfirmedMail());
        }

        return $this->doUpdate($request, $id);
    }

    public function remove(UserRemoveRequest $request, int $id): JsonResponse
    {
        return $this->doRemove($request, $id);
    }
}
