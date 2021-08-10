<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UnauthorisedException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class LoginController extends Controller
{
    /**
     * The only action of this controller which start the process of login
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function do(Request $request): JsonResponse
    {
        $this->doValidation($request);

        try {

            $tokenData = $this->doLogin($request);
            return $this->returnJson($tokenData);

        } catch (UnauthorisedException $exception) {

            return $this->returnJson([], JsonResponse::HTTP_UNAUTHORIZED, 'The credentials are not match with our records!');

        } catch (Throwable $exception) {

            Log::error($exception);
            return $this->returnJson([], JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'Oops! something bad happened.');

        }
    }

    /**
     * The private action of validation related to main action of this controller which is doing the login
     *
     * @param Request $request
     * @throws ValidationException
     */
    private function doValidation(Request $request): void
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
            'remember' => ['nullable', 'boolean']
        ];

        $this->validate($request, $rules);
    }

    /**
     * doing the main parts of login action especially the part which is related to the auth library
     *
     * @param Request $request
     * @return array
     * @throws UnauthorisedException
     */
    private function doLogin(Request $request): array
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        $remember = false;
        if ($request->has('remember')) {
            $remember = (bool)$request->get('remember');
        }

        if (auth()->attempt($credentials, $remember)) {
            /** @var User $user */
            $user = auth()->user();
            $token = $user->createToken('DeviceName');

            $result = [
                'token' => $token->accessToken,
                'expires_at' => $token->token->expires_at,
                'name' => $user->getName()
            ];

            return $result;
        }

        throw new UnauthorisedException();
    }
}