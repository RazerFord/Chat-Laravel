<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function login(LoginFormRequest $request)
    {
        dd($request->safe());
    }
}
