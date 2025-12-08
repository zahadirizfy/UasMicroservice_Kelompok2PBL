<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * REGISTER
     */
    public function register(Request $request)
    {
        Log::info('[Auth] Register called', ['payload' => $request->all()]);

        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'])
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'token' => $token,
                'user' => $user
            ], 201);

        } catch (ValidationException $e) {
            Log::warning('[Auth] Register validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('[Auth] Register error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to register user'], 500);
        }
    }


    /**
     * LOGIN
     */
    public function login(Request $request)
    {
        Log::info('[Auth] Login attempt', ['email' => $request->email]);

        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                Log::warning('[Auth] Invalid credentials', ['email' => $request->email]);
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ], 200);

        } catch (ValidationException $e) {
            Log::warning('[Auth] Login validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('[Auth] Login error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to login'], 500);
        }
    }


    /**
     * PROFILE (Protected)
     */
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], 200);
    }


    /**
     * LOGOUT (Protected)
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            Log::info('[Auth] User logged out', ['id' => $request->user()->id]);

            return response()->json(['message' => 'Logged out successfully'], 200);

        } catch (\Throwable $e) {
            Log::error('[Auth] Logout error', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to logout'
            ], 500);
        }
    }
}
