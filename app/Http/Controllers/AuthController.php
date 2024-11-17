<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * @OA\Tag(
 *     name="Authentification",
 *     description="Authentification",
 * ),
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Authentification"},
     *     summary="Register",
     *     description="Register",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Account created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'message' => 'User succesfully registered',
            'user' => $user,
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentification"},
     *     summary="Login",
     *     description="Login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logged in",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Wrong Credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return response()->json([
                'message' => 'User successfully logged in'
            ], 200);
        }

        return response()->json([
            'message' => 'Wrong Credentials'
        ], 401);
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Authentification"},
     *     summary="Get authenticated user",
     *     description="Get authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function user(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Authentification"},
     *     summary="Logout",
     *     description="Logout",
     *     @OA\Response(
     *         response=200,
     *         description="Logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        // Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'User successfully logged out'
        ], 200);
    }
}
