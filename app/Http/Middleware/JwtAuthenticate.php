<?php

namespace App\Http\Middleware;

use App\Helpers\Jwt;
use Closure;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\MessageBag;

class JwtAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = Jwt::getToken();
        if (!$token) {
            return redirect()->to('/login');
        }
        if ($token->isExpired() || $token->beforeValid()) {
            $error = new MessageBag();
            $error->add('JWT', 'Ha expirado la sesión');
            Jwt::clearToken();
            return redirect()->to('/login')->withErrors($error);
        }

        return $next($request);
    }
}
