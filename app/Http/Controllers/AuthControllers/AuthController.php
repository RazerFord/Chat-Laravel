<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Models\User;
use App\Responses\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    /**
     * Login user.
     * 
     * @param LoginFormRequest $request
     * @return JsonResponse
     */
    public function login(LoginFormRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return SuccessResponse::response(Response::$statusTexts[Response::HTTP_UNAUTHORIZED], null, Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();

        $token = $user->createToken(config('app.name'))->plainTextToken;

        return SuccessResponse::response(Response::$statusTexts[Response::HTTP_OK], ['token' => $token], Response::HTTP_OK);
    }

    /**
     * Get authenticated user.
     * 
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return SuccessResponse::response(Response::$statusTexts[Response::HTTP_OK], [$user->only('name', 'email')], Response::HTTP_OK);
    }

    /**
     * Logout.
     * 
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return SuccessResponse::response(Response::$statusTexts[Response::HTTP_OK], null, Response::HTTP_OK);
    }
}
