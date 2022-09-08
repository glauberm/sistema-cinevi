<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
use App\Models\User as UserModel;
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
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware(Authenticate::class.':sanctum')->except([
            'login', 'register', 'finalizeRegistration', 'getAuthenticatedUser', 'requestResetPassword', 'resetPassword',
        ]);

        $this->middleware(ValidateSignature::class)->only(['finalizeRegistration', 'resetPassword', 'updateEmail']);

        if (! App::environment('testing')) {
            $this->middleware(ThrottleRequests::class.':5,15')->only(['login']);
        }

        $this->userService = $userService;
    }

    /**
     * @param  AuthenticationLoginRequest  $request
     * @return JsonResponse
     */
    public function login(AuthenticationLoginRequest $request): JsonResponse
    {
        /** @var array{email:string,password:string} */
        $data = $request->validated();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            if (Auth::user() !== null && Auth::user()->is_enabled && Auth::user()->is_confirmed) {
                return response()->json([
                    'message' => 'Você entrou no sistema.',
                    'resource' => new User(Auth::user()),
                ]);
            }

            if (Auth::user() !== null && ! Auth::user()->is_enabled) {
                $this->sendFinalizeRegistrationMail(Auth::user());

                Auth::guard('web')->logout();

                throw new AuthenticationException(
                    'Seu email ainda não foi confirmado. O email de confirmação foi reenviado.'
                );
            }

            if (Auth::user() !== null && ! Auth::user()->is_confirmed) {
                Auth::guard('web')->logout();

                throw new AuthenticationException(
                    'Seu cadastro ainda não foi confirmado pelo departamento. Quando ele for, você receberá um email.'
                );
            }
        }

        throw new AuthenticationException('O email ou senha estão incorretos.');
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::guard('web')->logout();

        return response()->json(['message' => 'Você saiu do sistema.']);
    }

    /**
     * @return JsonResponse|User
     */
    public function getAuthenticatedUser(): JsonResponse|User
    {
        $user = Auth::user();

        if ($user === null) {
            return response()->json(['message' => 'Não há nenhum usuário autenticado.', 'data' => false], 404);
        } else {
            return new User(Auth::user());
        }
    }

    /**
     * @param  AuthenticationRegisterRequest  $request
     * @return JsonResponse
     */
    public function register(AuthenticationRegisterRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $data['is_enabled'] = false;
        $data['is_confirmed'] = false;
        $data['roles'] = ['user'];

        /** @var UserModel $user */
        $user = $this->userService->create($data, 'register', 'O usuário foi cadastrado.');

        $this->sendFinalizeRegistrationMail($user);

        return response()->json([
            'message' => "Foi enviado para {$user->email} um link válido por 60 minutos para você finalizar o seu
             cadastro.",
        ]);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function finalizeRegistration(int $id): JsonResponse
    {
        /** @var UserModel $user */
        $user = $this->userService->get($id);

        if ($user->is_enabled === true) {
            return response()->json([
                'message' => 'Seu email já foi confirmado.',
            ]);
        }

        $this->userService->update(
            ['is_enabled' => true],
            $id,
            'finalize_registration',
            'O cadastro do usuário foi finalizado.'
        );

        $departmentUsers = $this->userService->getAllWithRole('department');

        foreach ($departmentUsers as $user) {
            $url = URL::temporarySignedRoute(
                'authentication.reset_password',
                CarbonImmutable::now()->addMinutes(60),
                ['id' => $user->id]
            );

            Mail::to($user->email)->queue(new AuthenticationResetPasswordMail($url));
        }

        return response()->json([
            'message' => 'Seu email foi confirmado, mas o departamento ainda precisa confirmar seu cadastro. Você 
            receberá um email em breve.',
        ]);
    }

    /**
     * @param  AuthenticationRequestResetPasswordRequest  $request
     * @return JsonResponse
     */
    public function requestResetPassword(AuthenticationRequestResetPasswordRequest $request): JsonResponse
    {
        /** @var array{email:string} */
        $data = $request->validated();

        $email = $data['email'];

        $user = $this->userService->getByEmail($email);

        if (\is_null($user)) {
            throw new ModelNotFoundException('Um usuário com esse email não foi encontrado no sistema.');
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
     * @param  int  $id
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
            'message' => "Foi enviado para {$email} um link válido por 60 minutos para finalizar a atualização do seu email.",
        ]);
    }

    /**
     * @param  int  $id
     * @param  string  $email
     * @return JsonResponse
     */
    public function updateEmail(int $id, string $email): JsonResponse
    {
        $currentUserId = Auth::id();

        if (\is_null($currentUserId)) {
            throw new AuthorizationException('O id do usuário atual não foi encontrado.');
        }

        if ($currentUserId !== $id) {
            throw new AuthorizationException('O id do usuário atual não bate com o id da URL.');
        }

        $this->userService->update(
            ['email' => $email],
            \intval($currentUserId),
            'update_email',
            'O email do usuário foi atualizado.'
        );

        Auth::guard('web')->logout();

        return response()->json(['message' => 'email editado com sucesso. Por favor, entre com seu novo email.']);
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

        if (\is_null($currentUserId)) {
            throw new AuthorizationException('O id do usuário atual não foi encontrado.');
        }

        $password = $data['new_password'];

        $this->userService->update(
            ['password' => $password],
            \intval($currentUserId),
            'update_password',
            'A senha do usuário foi atualizada.',
        );

        Auth::guard('web')->logout();

        return response()->json(['message' => 'Senha editada com sucesso. Por favor, entre com sua nova senha.']);
    }

    /**
     * @param  UserModel  $user
     * @return void
     */
    private function sendFinalizeRegistrationMail(UserModel $user): void
    {
        $url = URL::temporarySignedRoute(
            'authentication.finalize_registration',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        Mail::to($user->email)->queue(new AuthenticationFinalizeRegistrationMail($url));
    }
}
