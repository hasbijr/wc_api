<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    const API_TOKEN = 'https://apifactory.telkom.co.id:8243/hcm/auth/v1/token';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'login']);
    }

    public function login(Request $request)
    {
        $this->validate($request, User::getValidationRules());

        // try {
        //     $curl = curl_init();
        //     curl_setopt($curl, CURLOPT_URL, self::API_TOKEN);
        //     curl_setopt($curl, CURLOPT_POST, TRUE);
        //     curl_setopt($curl, CURLOPT_POSTFIELDS, [
        //         'username' => $request->username,
        //         'password' => $request->password,
        //     ]);
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //     $responseBody = curl_exec($curl);
        //     curl_close($curl);

        //     $responseBody = json_decode($responseBody, true);
        // } catch (Exception $e) {
        //     return $this->writeResponse(self::HTTP_STATUS_ERROR, 'auth: api error', false);
        // }

        // if ($responseBody['status'] == 'failed') {
        //     return $this->writeResponse(self::HTTP_STATUS_UNAUTHORIZED, 'api: invalid credentials', false);
        // }

        // $user = User::where('username', $request->username)->firstOrFail();

        // if (!$user) {
        //     return $this->writeResponse(self::HTTP_STATUS_UNAUTHORIZED, 'invalid credentials', false);
        // }

        // $token = JWTAuth::fromUser($user);

        /**
         * ===============================
         */
        $credentials = request(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->writeResponse(self::HTTP_STATUS_UNAUTHORIZED, 'invalid credentials', false);
        }
        /**
         * ===============================
         */

        return $this->respondWithToken($token);
    }

    /**
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function profile(Request $request)
    {
        $user = auth()->user();
        $user->getAllPermissions();
        $user->getRoleNames();

        return response()->json($user);
    }
}
