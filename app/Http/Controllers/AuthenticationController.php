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
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * Tenta realizar a autenticação e lida com o sucesso ou erro.
     *
     * @return JsonResponse
     *
     * @throws UnauthorizedHttpException
     */
    public function login(AuthenticationLoginRequest $request): JsonResponse
    {
        /** @var array{email: string, password: string} */
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
            throw new \UnexpectedValueException('O usuário da requisição não foi encontrado.');
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

    /**
     * Faz o cadastro de um usuário desativado e envia o e-mail para finalização de cadastro.
     *
     * @param  AuthenticationRegisterRequest  $request
     * @return JsonResponse
     */
    public function register(AuthenticationRegisterRequest $request): JsonResponse
    {
        /** @var mixed[] $data */
        $data = $request->validated();

        $data['roles'] = ['user'];

        /** @var UserModel $user */
        $user = $this->userService->create($data, 'register', 'O usuário foi cadastrado.');

        $url = URL::temporarySignedRoute(
            'authentication.finalize_registration',
            now()->addMinutes(60),
            ['id' => $user->id]
        );

        Mail::to($user->email)->queue(new AuthenticationFinalizeRegistrationMail($url));

        return response()->json([
            'message' => "Foi enviado para {$user->email} um link válido por 60 minutos para você finalizar o seu cadastro.",
        ]);
    }

    /**
     * Realiza a finalização do cadastro através de uma URL com assinatura.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function finalizeRegistration(int $id): JsonResponse
    {
        $currentUserId = Auth::id();

        if (\is_null($currentUserId)) {
            throw new UnauthorizedHttpException('', 'O id do usuário atual não foi encontrado.');
        }

        if ($currentUserId !== $id) {
            throw new UnauthorizedHttpException('', 'O id do usuário atual não bate com o id da URL.');
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
     * Envia email com link para redefinir senha.
     *
     * @param  AuthenticationRequestResetPasswordRequest  $request
     * @return JsonResponse
     *
     * @throws NotFoundHttpException
     */
    public function requestResetPassword(AuthenticationRequestResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!\is_array($data)) {
            throw new \TypeError('Os dados da requisição não são um array.');
        }

        $email = $data['email'];

        if ($user = $this->userService->getByEmail($email)) {
            $url = URL::temporarySignedRoute(
                'authentication.reset_password',
                now()->addMinutes(60),
                ['id' => $user->id]
            );

            Mail::to($user->email)->queue(new AuthenticationResetPasswordMail($url));

            return response()->json([
                'message' => "Foi enviado para {$email} um link válido por 60 minutos para redefinição de senha.",
            ]);
        }

        throw new NotFoundHttpException('Um usuário com esse e-mail não foi encontrado no sistema.');
    }

    /**
     * Redefine senha.
     *
     * @param  AuthenticationResetPasswordRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function resetPassword(AuthenticationResetPasswordRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        if (!\is_array($data)) {
            throw new \TypeError('Os dados da requisição não são um array.');
        }

        $this->userService->update($data, $id, 'reset_password', 'A senha do usuário foi redefinida.');

        return response()->json([
            'message' => 'Sua senha foi redefinida. Você já pode entrar no sistema com sua nova senha.',
        ]);
    }

    /**
     * Solicita a atualização do email do usuário autenticado.
     *
     * @param  AuthenticationRequestUpdateEmailRequest  $request
     * @return JsonResponse
     */
    public function requestUpdateEmail(AuthenticationRequestUpdateEmailRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!\is_array($data)) {
            throw new \TypeError('Os dados da requisição não são um array.');
        }

        $currentUserId = Auth::id();

        if (!\is_null($currentUserId)) {
            $email = $data['email'];

            $url = URL::temporarySignedRoute(
                'authentication.update_email',
                now()->addMinutes(60),
                ['id' => $currentUserId, 'email' => $email]
            );

            Mail::to($email)->queue(new AuthenticationUpdateEmailMail($url));

            return response()->json([
                'message' => "Foi enviado para {$email} um link válido por 60 minutos para finalizar a atualização do seu e-mail.",
            ]);
        }

        throw new UnauthorizedHttpException('', 'O id do usuário atual não foi encontrado.');
    }

    /**
     * Atualiza o email do usuário autenticado.
     *
     * @param  Request  $request
     * @param  int  $id
     * @param  string  $email
     * @return JsonResponse
     */
    public function updateEmail(Request $request, int $id, string $email): JsonResponse
    {
        $currentUserId = Auth::id();

        if (!\is_null($currentUserId)) {
            if ($currentUserId !== $id) {
                throw new UnauthorizedHttpException('', 'O id do usuário atual não bate com o id da URL.');
            }

            $this->userService->update(
                ['email' => $email],
                \intval($currentUserId),
                'update_email',
                'O e-mail do usuário foi atualizado.'
            );

            if ($request->user() === null) {
                throw new \ErrorException('O usuário da requisição não foi encontrado.');
            }

            $request->user()->tokens()->delete();

            return response()->json(['message' => 'E-mail editado com sucesso. Por favor, entre com seu novo e-mail.']);
        }

        throw new UnauthorizedHttpException('', 'O id do usuário atual não foi encontrado.');
    }

    /**
     * Atualiza a senha do usuário autenticado.
     *
     * @param  AuthenticationUpdatePasswordRequest  $request
     * @return JsonResponse
     */
    public function updatePassword(AuthenticationUpdatePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!\is_array($data)) {
            throw new \TypeError('Os dados da requisição não são um array.');
        }

        $currentUserId = Auth::id();

        if (!\is_null($currentUserId)) {
            $password = $data['new_password'];

            $this->userService->update(
                ['password' => $password],
                \intval($currentUserId),
                'update_password',
                'A senha do usuário foi atualizada.',
            );

            if ($request->user() === null) {
                throw new \ErrorException('O usuário da requisição não foi encontrado.');
            }

            $request->user()->tokens()->delete();

            return response()->json(['message' => 'Senha editada com sucesso. Por favor, entre com sua nova senha.']);
        }

        throw new UnauthorizedHttpException('', 'O id do usuário atual não foi encontrado.');
    }
}
