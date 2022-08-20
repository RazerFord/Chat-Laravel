<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginFormRequest;
use App\Responses\SuccessResponse;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthService implements ServiceInterface
{
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
}
