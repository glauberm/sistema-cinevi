<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationLoginRequest;
use App\Http\Requests\AuthenticationRegisterRequest;
use App\Http\Requests\AuthenticationRequestResetPasswordRequest;
use App\Http\Requests\AuthenticationRequestUpdateEmailRequest;
use App\Http\Requests\AuthenticationResetPasswordRequest;
use App\Http\Requests\AuthenticationUpdatePasswordRequest;
use App\Http\Resources\User;
use App\Mail\AuthenticationFinalizeRegistrationMail;
use App\Mail\AuthenticationResetPasswordMail;
use App\Mail\AuthenticationUpdateEmailMail;
use App\Models\User as UserModel;
use App\Services\UserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware(Authenticate::class . ':sanctum')->except(['login', 'register', 'requestResetPassword', 'resetPassword']);

        $this->middleware(ValidateSignature::class)->only(['finalizeRegistration', 'resetPassword', 'updateEmail']);

        if (!App::environment('testing')) {
            $this->middleware(ThrottleRequests::class . ':10,1')->only(['login']);
        }

        $this->userService = $userService;
    }

    /**
     * @return JsonResponse
     */
    public function login(AuthenticationLoginRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return new JsonResponse(['message' => 'Você entrou no sistema.']);
        }

        throw new AuthenticationException('O e-mail ou senha estão incorretos.');
    }

    /**
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            throw new AuthorizationException('O usuário da requisição não foi encontrado.');
        }

        $user->tokens()->delete();

        return response()->json(['message' => 'Você saiu do sistema.']);
    }

    /**
     * @return User
     */
    public function getAuthenticatedUser(): User
    {
        $user = Auth::user();

        if ($user === null) {
            throw new AuthorizationException('O usuário atual não foi encontrado.');
        }

        return new User(Auth::user());
    }

    /**
     * @param  AuthenticationRegisterRequest  $request
     * @return JsonResponse
     */
    public function register(AuthenticationRegisterRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $data['roles'] = ['user'];

        /** @var UserModel $user */
        $user = $this->userService->create($data, 'register', 'O usuário foi cadastrado.');

        $url = URL::temporarySignedRoute(
            'authentication.finalize_registration',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        Mail::to($user->email)->queue(new AuthenticationFinalizeRegistrationMail($url));

        return response()->json([
            'message' => "Foi enviado para {$user->email} um link válido por 60 minutos para você finalizar o seu cadastro.",
        ]);
    }

    /**
     * @param  integer       $id
     * @return JsonResponse
     */
    public function finalizeRegistration(int $id): JsonResponse
    {
        $currentUserId = Auth::id();

        if (\is_null($currentUserId)) {
            throw new AuthorizationException('O id do usuário atual não foi encontrado.');
        }

        if ($currentUserId !== $id) {
            throw new AuthorizationException('O id do usuário atual não bate com o id da URL.');
        }

        $this->userService->update(
            ['is_enabled' => true],
            $id,
            'finalize_registration',
            'O cadastro do usuário foi finalizado.'
        );

        return response()->json([
            'message' => 'Seu cadastro foi finalizado com sucesso. Você já pode entrar no sistema.',
        ]);
    }

    /**
     * @param  AuthenticationRequestResetPasswordRequest  $request
     * @return JsonResponse
     */
    public function requestResetPassword(AuthenticationRequestResetPasswordRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        /** @var string */
        $email = $data['email'];

        $user = $this->userService->getByEmail($email);

        if (\is_null($user)) {
            throw new ModelNotFoundException('Um usuário com esse e-mail não foi encontrado no sistema.');
        }

        $url = URL::temporarySignedRoute(
            'authentication.reset_password',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        Mail::to($user->email)->queue(new AuthenticationResetPasswordMail($url));

        return response()->json([
            'message' => "Foi enviado para {$email} um link válido por 60 minutos para redefinição de senha.",
        ]);
    }

    /**
     * @param  AuthenticationResetPasswordRequest  $request
     * @param  integer                             $id
     * @return JsonResponse
     */
    public function resetPassword(AuthenticationResetPasswordRequest $request, int $id): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $this->userService->update($data, $id, 'reset_password', 'A senha do usuário foi redefinida.');

        return response()->json([
            'message' => 'Sua senha foi redefinida. Você já pode entrar no sistema com sua nova senha.',
        ]);
    }

    /**
     * @param  AuthenticationRequestUpdateEmailRequest  $request
     * @return JsonResponse
     */
    public function requestUpdateEmail(AuthenticationRequestUpdateEmailRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $currentUserId = Auth::id();

        if (\is_null($currentUserId)) {
            throw new AuthorizationException('O id do usuário atual não foi encontrado.');
        }

        /** @var string */
        $email = $data['email'];

        $url = URL::temporarySignedRoute(
            'authentication.update_email',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $currentUserId, 'email' => $email]
        );

        Mail::to($email)->queue(new AuthenticationUpdateEmailMail($url));

        return response()->json([
            'message' => "Foi enviado para {$email} um link válido por 60 minutos para finalizar a atualização do seu e-mail.",
        ]);
    }

    /**
     * @param  Request  $request
     * @param  integer  $id
     * @param  string   $email
     * @return JsonResponse
     */
    public function updateEmail(Request $request, int $id, string $email): JsonResponse
    {
        $currentUserId = Auth::id();

        $requestUser = $request->user();

        if (\is_null($currentUserId)) {
            throw new AuthorizationException('O id do usuário atual não foi encontrado.');
        }

        if ($currentUserId !== $id) {
            throw new AuthorizationException('O id do usuário atual não bate com o id da URL.');
        }

        if ($requestUser === null) {
            throw new AuthorizationException('O usuário da requisição não foi encontrado.');
        }

        $this->userService->update(
            ['email' => $email],
            \intval($currentUserId),
            'update_email',
            'O e-mail do usuário foi atualizado.'
        );

        $requestUser->tokens()->delete();

        return response()->json(['message' => 'E-mail editado com sucesso. Por favor, entre com seu novo e-mail.']);
    }

    /**
     * @param  AuthenticationUpdatePasswordRequest  $request
     * @return JsonResponse
     */
    public function updatePassword(AuthenticationUpdatePasswordRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $currentUserId = Auth::id();

        $requestUser = $request->user();

        if (\is_null($currentUserId)) {
            throw new AuthorizationException('O id do usuário atual não foi encontrado.');
        }

        if ($requestUser === null) {
            throw new AuthorizationException('O usuário da requisição não foi encontrado.');
        }

        $password = $data['new_password'];

        $this->userService->update(
            ['password' => $password],
            \intval($currentUserId),
            'update_password',
            'A senha do usuário foi atualizada.',
        );

        $requestUser->tokens()->delete();

        return response()->json(['message' => 'Senha editada com sucesso. Por favor, entre com sua nova senha.']);
    }
}
