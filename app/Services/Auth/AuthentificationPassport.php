<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interface\AuthentificationInterface;


class AuthentificationPassport implements AuthentificationInterface
{
    public function authentificate(Request $request)
    {
        $credentials = $request->only('telephone', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::find(id: Auth::user()->id);

            // Create access and refresh tokens
            $token = $user->createToken('appToken')->accessToken;
            $refreshToken = $user->createToken('refreshToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'refresh_token' => $refreshToken,
                // 'user' => new UserResource($user),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Échec de l\'authentification.',
            ], 401);
        }
    }

    public function refreshToken(Request $request)
    {
        // Validate input
        $request->validate([
            'telephone' => 'required|string',
            'password' => 'required|string',
        ]);

        // Authenticate user
        if (!Auth::attempt($request->only('telephone', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants invalides.'
            ], 401);
        }

        // Retrieve authenticated user
        $user = User::find(Auth::user()->id);

        // Create new access and refresh tokens
        $newAccessToken = $user->createToken('appToken')->accessToken;
        $newRefreshToken = $user->createToken('refreshToken')->accessToken;

        return response()->json([
            'success' => true,
            'token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
            'user' => new UserResource($user),
        ], 200);
    }

    public function logout()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve the authenticated user
            // $user = Auth::user();
            $user = User::find(id: Auth::user()->id);


            /* @var \App\Models\User $user */
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Déconnexion réussie. Vous devez vous reconnecter pour accéder à l\'application.'
            ], 200);
        }

        return response()->json([
            'message' => 'Utilisateur non authentifié.'
        ], 401);
    }
}
