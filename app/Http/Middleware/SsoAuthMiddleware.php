<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        // $baseUrl = config('services.e-portal.url_portal_session');
        // $key_cookies = $_COOKIE[config('services.e-portal.key_cookies')] ?? null;
        // Log::info('This is cookies tcel_sso: ' . $key_cookies);
        // $url  = rtrim($baseUrl, '/') . '/' . ltrim($key_cookies, '/');

        // $headers = [
        //     'Username' => config('services.e-portal.username'),
        //     'Password' => config('services.e-portal.password'),
        // ];

        // $response = Http::withOptions(['verify' => false])
        //     ->withHeaders($headers)
        //     ->get($url);

        // // Log::info('Response SSO_TCEL: ' . $response);
        // $sso_data = $response->json();


        // if (!$sso_data) {
        //     return response("You are not authorized to access this resource.", 401);
        // }

        // if ($sso_data['success'] !== true) {
        //     return response("You are not authorized to access this resource.", 401);
        // }

        // session(['sso_user' => $sso_data['data']]);


        return $next($request);
    }
}
