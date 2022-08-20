<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Models\User;
use App\Responses\SuccessResponse;
use App\Services\AuthService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    /**
     * Initialize class of service.
     * 
     * @param AuthService
     * @return void
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Return form of authorization.
     * 
     * @retutn view
     */
    public function index(): View|Factory
    {
        return view('auth');
    }

    /**
     * Login user.
     * 
     * @param LoginFormRequest $request
     * @return JsonResponse
     */
    public function login(LoginFormRequest $request): JsonResponse
    {
        return $this->service->login($request);
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
