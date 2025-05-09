<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    /**
     * Register a new user.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) 
    {
        $data = $request->validated();

        // create new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);


        $user->sendEmailVerificationNotification();

        //  return user with token session
        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => 'Usuario creado correctamente',
            'user' => $data
        ], 201);


    }

    /**
     * Authenticate a user and issue a token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        
        // find user
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 401);
        }

        // check credentials 
        if(!Auth::attempt($data)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // return user with token session
        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => 'Usuario autenticado correctamente',
            'user' => $user
        ], 200);

    }



    /**
     * Logout the authenticated user (revoke the token).
     */
    public function logout(Request $request) 
    {
        $user = $request->user();

        // revoke the token
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ], 200);

    } 

    /**
     * Verify the user's email address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $hash
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // check if user is verified
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email ya verificado'
            ], 200);
        }

        // verify email
        if (!hash_equals((string) $hash, (string) sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Hash no coincide'
            ], 403);
        }

        $user->markEmailAsVerified();

        return response()->json([
            'message' => 'Email verificado correctamente'
        ], 200);

    }


    public function resendVerifyEmail(Request $request)
    {
        $user = $request->user();

        // check if user is verified
        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Email ya verificado'
            ], 200);
        }

        // verify email
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Email de verificación enviado'
        ], 200);

    }
    

}
