<?php

namespace App\Http\Middleware;

use App\Helpers\Jwt;
use Closure;
use Hamcrest\Text\StringContains;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, string $role = 'admin')
    {
        $token = Jwt::getToken();
        if ($token && !$token->hasRole($role)) {
            $error = new MessageBag();
            $error->add('Permisos', 'No tiene permisos suficientes');
            abort(401);
        }

        return $next($request);
    }
}
