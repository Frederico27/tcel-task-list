<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTaskMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sso_data = session('sso_user');

        if (!$sso_data) {
            session()->flush();
            return response("You are not authorized to access this resource.", 401);
        }

        if (!in_array(259, $sso_data['treemenuid'])) {
            return redirect('https://e-portal.telkomcel.tl/app/ext/tasklist/audit/user');
        }

        return $next($request);
    }
}
