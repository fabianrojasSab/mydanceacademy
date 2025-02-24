<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{


    /**
     *@api

     */
    public function getToken(Request $request)
    {
        $token = csrf_token();
        return response()->json(['token' => $token]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validator = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:4',
            ]);

            $email = $request->input('email'); // O simplemente $request->email
            $password = $request->input('password');

            $user = User::where('email', $email)->first();

            // Verificar si el usuario existe y la contraseña es correcta
            if (!$user || !Hash::check($password, $user->password)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            Log::info('Generating token for user', [
                'user_id' => $user->id,
                'jwt_ttl' => config('jwt.ttl'),
            ]);

            $userid = $user->id;
            $jwt_ttl = config('jwt.ttl');

            // Generar el token JWT
            $token = JWTAuth::fromUser($user);

            // Verificar si el token se generó correctamente
            if (!$token) {
                return response()->json(['error' => 'Could not create token'], 500);
            }

            return $this->respondWithToken($token);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred', 'message' => $th->getMessage()], 500);
        }
    }



    public function updatePassword(Request $request)
    {

        $email = request('email');
        $password = request('password');

        $user = User::where('email', $email)->firstOrFail();
        $user->password = Hash::make($password); // Hash the password
        $user->save();


        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Password updated and token generated successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function meToken()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            // Invalida el token JWT
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Maneja el error si ocurre al invalidar el token
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function refresh()
    {
        try {
            // Obtiene el token actual
            $token = JWTAuth::getToken();

            // Intenta refrescar el token
            $newToken = JWTAuth::refresh($token);

            // Responde con el nuevo token
            // $this->respondWithToken($newToken);
            return $newToken;
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Maneja el error si ocurre
            return response()->json(['error' => 'Failed to refresh token, please try again'], 500);
        }
    }


    public function refreshToken(Request $request)
    {
        // Obtener el refresh token del cliente
        $refresh_token = $request->input('refresh_token');

        // Verificar si el refresh token es válido y obtener el usuario asociado
        // if ($user = Auth::guard('api')->setToken($refresh_token)->user()) {
        //     // El refresh token es válido, generar un nuevo access token
        //     $access_token = Auth::guard('api')->login($user);

        //     // Devolver el nuevo access token al cliente
        //     return response()->json([
        //         'access_token' => $access_token,
        //     ]);
        // }

        // El refresh token no es válido o no está asociado con un usuario, responder con un error
        return response()->json(['error' => 'Invalid refresh token'], 401);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiresIn = JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
