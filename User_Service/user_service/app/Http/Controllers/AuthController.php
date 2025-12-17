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
     * (OPSIONAL) WEB LOGIN PAGE
     * Kalau user_service kamu murni API, boleh hapus method ini.
     */
    public function loginPage()
    {
        // kalau tidak punya view, bisa return json saja
        // return view('auth.login');
        return response()->json(['message' => 'User Service Login Page'], 200);
    }

    /**
     * REGISTER (API)
     * POST /api/auth/register
     */
    public function apiRegister(Request $request)
    {
        Log::info('[Auth] Register called', ['payload' => $request->all()]);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'token' => $token,
                'token_type' => 'Bearer',
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
     * LOGIN (API)
     * POST /api/auth/login
     */
    public function apiLogin(Request $request)
    {
        Log::info('[Auth] Login attempt', ['email' => $request->email]);

        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                Log::warning('[Auth] Invalid credentials', ['email' => $validated['email']]);
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // (opsional) kalau kamu punya kolom is_approved
            // if (property_exists($user, 'is_approved') && !$user->is_approved) {
            //     return response()->json(['message' => 'Account not approved'], 403);
            // }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'token_type' => 'Bearer',
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
     * PROFILE (API Protected)
     * GET /api/auth/profile
     */
    public function apiProfile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], 200);
    }

    /**
     * LOGOUT (API Protected)
     * POST /api/auth/logout
     */
    public function apiLogout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            $user->currentAccessToken()->delete();

            Log::info('[Auth] User logged out', ['id' => $user->id]);

            return response()->json(['message' => 'Logged out successfully'], 200);

        } catch (\Throwable $e) {
            Log::error('[Auth] Logout error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to logout'], 500);
        }
    }
}
