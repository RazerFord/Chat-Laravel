<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Models\User;
use App\Responses\SuccessResponse;
use App\Services\AuthService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function index(): View|Factory|Redirector|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('chat.index'));
        }

        return view('auth');
    }

    /**
     * Login user.
     * 
     * @param LoginFormRequest $request
     * @return View|Factory|Redirector|RedirectResponse
     */
    public function login(LoginFormRequest $request): View|Factory|Redirector|RedirectResponse
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
