<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRemoveRequest;
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

    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->middleware(Authenticate::class . ':sanctum');
        $this->service = $service;
    }

    /**
     * @param  UserUpdateRequest  $request
     * @param  integer                    $id
     * @return JsonResponse
     */
    public function doUpdate(UserUpdateRequest $request, int $id): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        /** @var UserModel $user */
        $user = $this->service->get($id);

        if ($user->is_confirmed === false && $data['is_confirmed']) {
            Mail::to($user->email)->queue(new UserIsConfirmedMail());
        }

        return $this->update($request, $id);
    }

    /**
     * @param  UserRemoveRequest  $request
     * @param  integer            $id
     * @return JsonResponse
     */
    public function doRemove(UserRemoveRequest $request, int $id): JsonResponse
    {
        return $this->remove($request, $id);
    }
}
