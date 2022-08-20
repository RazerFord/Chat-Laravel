<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginFormRequest;
use App\Responses\SuccessResponse;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthService implements ServiceInterface
{
    public function login(LoginFormRequest $request): View|Factory|Redirector|RedirectResponse
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'approve' => 'Wrong password or email.',
            ]);
        }

        $user = $request->user();

        $token = $user->createToken(config('app.name'))->plainTextToken;

        return redirect()->back();
    }
}
