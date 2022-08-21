<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserChat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProtectionChat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!UserChat::haveAccess(Auth::user(), $request->id)) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
