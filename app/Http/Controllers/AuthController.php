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

}
