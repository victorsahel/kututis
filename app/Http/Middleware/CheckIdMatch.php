<?php

namespace App\Http\Middleware;

use App\Helpers\Jwt;
use Closure;

class CheckIdMatch
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $id = $request->route('id_medico');
        if ($id != Jwt::getToken()->getSubject()) {
            abort(401);
        }
        return $next($request);
    }
}
