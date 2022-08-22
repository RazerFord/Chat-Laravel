<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Responses\SuccessResponse;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    /**
     * Initialize class of service.
     * 
     * @param UserService
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request, User $user)
    {
        $users = $user->getUserByFilter($request)->where('id', '<>', Auth::user()->id)->get();

        return SuccessResponse::response(
            Response::$statusTexts[Response::HTTP_OK],
            $users->toArray(),
            Response::HTTP_OK
        );
    }
}
