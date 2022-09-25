<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Middleware\Authenticate;
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
use App\Mail\UserPendingApprovalMail;
use App\Models\User as UserModel;
use App\Services\AuthService;
use App\Services\UserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthenticationController extends Controller
{
    public function __construct(private readonly UserService $userService, private readonly AuthService $authService)
    {
        $this->middleware(Authenticate::class.':sanctum')->except([
            'login', 'register', 'finalizeRegistration', 'getAuthenticatedUser', 'requestResetPassword', 'resetPassword',
        ]);

        $this->middleware(ValidateSignature::class)->only(['finalizeRegistration', 'resetPassword', 'updateEmail']);

        if (! App::environment('testing')) {
            $this->middleware(ThrottleRequests::class.':5,5')->only(['login']);
        }
    }

    public function login(AuthenticationLoginRequest $request): JsonResponse
    {
        /** @var array{email:string,password:string} */
        $data = $request->validated();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            try {
                $authUser = $this->authService->getAuthUserOrFail();
            } catch (AuthorizationException $e) {
                $this->authService->logout();
                throw $e;
            }

            if ($authUser->is_enabled && $authUser->is_confirmed) {
                return response()->json([
                    'message' => 'Você entrou no sistema.',
                    'resource' => new User($authUser),
                ]);
            }

            if (! $authUser->is_enabled) {
                $this->sendFinalizeRegistrationMail($authUser);

                $this->authService->logout();

                throw new AuthenticationException(
                    'Seu email ainda não foi confirmado. O email de confirmação foi reenviado e deve chegar em 15 minutos.'
                );
            }

            if (! $authUser->is_confirmed) {
                $this->authService->logout();

                throw new AuthenticationException(
                    'Seu cadastro ainda não foi confirmado pelo departamento. Quando ele for, você receberá um email.'
                );
            }
        }

        throw new AuthenticationException('O email ou senha estão incorretos.');
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Você saiu do sistema.']);
    }

    public function getAuthenticatedUser(): JsonResponse|User
    {
        $user = Auth::user();

        if (\is_null($user)) {
            return response()->json(['message' => 'Não há nenhum usuário autenticado.', 'data' => false], 404);
        } else {
            return new User($user);
        }
    }

    public function register(AuthenticationRegisterRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $data['is_enabled'] = false;
        $data['is_confirmed'] = false;
        $data['roles'] = [];

        /** @var UserModel $user */
        $user = $this->userService->create($data, 'register', 'O usuário foi cadastrado.');

        $this->sendFinalizeRegistrationMail($user);

        return response()->json([
            'message' => "Foi enviado para {$user->email} um link válido por 60 minutos para você finalizar o seu cadastro. O email deve chegar em 15 minutos.",
        ]);
    }

    public function finalizeRegistration(int $id): JsonResponse
    {
        /** @var UserModel $user */
        $user = $this->userService->get($id);

        if ($user->is_enabled) {
            return response()->json(['message' => 'Seu email já foi confirmado.']);
        }

        $this->userService->update(['is_enabled' => true], $id, 'finalize_registration', 'O cadastro do usuário foi finalizado.');

        $departmentUsers = $this->userService->getAllWithRole(UserRole::Department);

        foreach ($departmentUsers as $user) {
            Mail::to($user->email)->queue(new UserPendingApprovalMail($user));
        }

        return response()->json([
            'message' => 'Seu email foi confirmado, mas o departamento ainda precisa aprovar seu cadastro. Você receberá um email nos próximos dias.',
        ]);
    }

    public function requestResetPassword(AuthenticationRequestResetPasswordRequest $request): JsonResponse
    {
        /** @var array{email:string} */
        $data = $request->validated();

        $email = $data['email'];

        $user = $this->userService->getByEmail($email);

        if (\is_null($user)) {
            throw new ModelNotFoundException('Um usuário com esse email não foi encontrado no sistema.');
        }

        $url = URL::temporarySignedRoute('authentication.reset_password', CarbonImmutable::now()->addMinutes(60), ['id' => $user->id]);

        Mail::to($user->email)->queue(new AuthenticationResetPasswordMail($url));

        return response()->json([
            'message' => "Foi enviado para {$email} um link válido por 60 minutos para redefinição de senha. O email deve chegar em 15 minutos.",
        ]);
    }

    public function resetPassword(AuthenticationResetPasswordRequest $request, int $id): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $this->userService->update($data, $id, 'reset_password', 'A senha do usuário foi redefinida.');

        return response()->json([
            'message' => 'Sua senha foi redefinida. Você já pode entrar no sistema com sua nova senha.',
        ]);
    }

    public function requestUpdateEmail(AuthenticationRequestUpdateEmailRequest $request): JsonResponse
    {
        $authId = $this->authService->getAuthIdOrFail();

        /** @var array<string,mixed> */
        $data = $request->validated();

        /** @var string */
        $email = $data['email'];

        $expiration = CarbonImmutable::now()->addMinutes(60);

        $url = URL::temporarySignedRoute('authentication.update_email', $expiration, ['id' => $authId, 'email' => $email]);

        Mail::to($email)->queue(new AuthenticationUpdateEmailMail($url));

        return response()->json([
            'message' => "Foi enviado para {$email} um link válido por 60 minutos para finalizar a atualização do seu email. O email deve chegar em 15 minutos.",
        ]);
    }

    public function updateEmail(int $id, string $email): JsonResponse
    {
        $authId = $this->authService->getAuthIdOrFail();

        $this->userService->update(['email' => $email], $authId, 'update_email', 'O email do usuário foi atualizado.');

        $this->authService->logout();

        return response()->json(['message' => 'email editado com sucesso. Por favor, entre com seu novo email.']);
    }

    public function updatePassword(AuthenticationUpdatePasswordRequest $request): JsonResponse
    {
        $authId = $this->authService->getAuthIdOrFail();

        /** @var array<string,mixed> */
        $data = $request->validated();

        $password = $data['new_password'];

        $this->userService->update(['password' => $password], $authId, 'update_password', 'A senha do usuário foi atualizada.');

        $this->authService->logout();

        return response()->json(['message' => 'Senha editada com sucesso. Por favor, entre com sua nova senha.']);
    }

    private function sendFinalizeRegistrationMail(UserModel $user): void
    {
        $url = URL::temporarySignedRoute('authentication.finalize_registration', CarbonImmutable::now()->addMinutes(60), ['id' => $user->id]);

        Mail::to($user->email)->queue(new AuthenticationFinalizeRegistrationMail($url));
    }
}
