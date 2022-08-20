<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Http\Request;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthService implements ServiceInterface
{
    /**
     * Login user.
     * 
     * @param LoginFormRequest $request
     * @return View|Factory|Redirector|RedirectResponse
     */
    public function login(LoginFormRequest $request): View|Factory|Redirector|RedirectResponse
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'approve' => 'Wrong password or email.',
            ]);
        }

        // $user = $request->user();

        // $token = $user->createToken(config('app.name'))->plainTextToken;

        return redirect(route('chat.index'));
    }

    /**
     * Logout user.
     * 
     * @param Request $request
     * @return View|Factory|Redirector|RedirectResponse
     */
    public function logout(Request $request): View|Factory|Redirector|RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login.index'));
    }
}
