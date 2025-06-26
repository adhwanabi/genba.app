<?php

namespace App\Http\Middleware;

use Closure;

class CheckEhsUser
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->npk !== 'ehs') {
            abort(403, 'Unauthorized');
        }
        
        return $next($request);
    }
}