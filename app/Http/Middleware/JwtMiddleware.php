<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Verifica si el usuario tiene el rol requerido
            if ($role && !$user->hasRole($role)) {
                throw UnauthorizedException::forRoles([$role]);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => 'Token es Invalido'], 401);
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json(['status' => 'Token es Expirado'], 401);
            } elseif ($e instanceof UnauthorizedException) {
                return response()->json(['status' => 'Acceso denegado: no tiene el rol requerido'], 403);
            } else {
                return response()->json(['status' => 'Autorizacion Token no encontrada'], 401);
            }
        }

        return $next($request);
    }
}
