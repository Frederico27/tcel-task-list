<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SsoAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sso_data  = $request->cookie('__secured_sso_tcel');

        if (!$sso_data) {
            return response("You are not authorized to access this resource.", 401);
        }

        $treemenu_id = config('services.e-portal.tree_menu_id');
        $sso_tree_menu = $sso_data['data']['treemenuid'] ?? [];

        if (!in_array($treemenu_id, $sso_tree_menu)) {
            return response("You are not authorized to access this resource.", 401);
        }

        if ($sso_data['success'] !== true) {
            return response("You are not authorized to access this resource.", 401);
        }

        session(['sso_user' => $sso_data['data']]);

        return $next($request);
    }
}
