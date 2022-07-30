<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationLoginRequest;
use App\Http\Resources\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class . ':sanctum')->except(['login']);

        if (!App::environment('testing')) {
            $this->middleware(ThrottleRequests::class . ':10,1')->only(['login']);
        }
    }

    /**
     * Tenta realizar a autenticação e lida com o sucesso ou erro.
     *
     * @return JsonResponse
     * @throws UnauthorizedHttpException
     */
    public function login(AuthenticationLoginRequest $request): JsonResponse
    {
        /**
         * @var array{email: string, password: string}
         */
        $data = $request->validated();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return new JsonResponse(['message' => 'Você entrou no sistema.']);
        }

        throw new UnauthorizedHttpException('', 'O e-mail ou senha estão incorretos.');
    }

    /**
     * Revoga o acesso do usuário da requisição atual.
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if ($request->user() === null) {
            throw new \ErrorException('O usuário da requisição não foi encontrado.');
        }

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Você saiu do sistema.']);
    }

    /**
     * Retorna o usuário autenticado.
     *
     * @return User
     */
    public function getAuthenticatedUser(): User
    {
        return new User(Auth::user());
    }
}
