<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // GET ALL USERS
    public function index()
    {
        Log::info('[UserService] GET /users called');

        try {
            $users = User::all();
            return response()->json($users, 200);

        } catch (\Throwable $e) {
            Log::error('[UserService] Error fetching users', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to fetch users',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // CREATE USER
    public function store(Request $request)
    {
        Log::info('[UserService] POST /users called', ['body' => $request->all()]);

        try {
            // VALIDATION
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);

            // CREATE USER
            $user = User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            Log::info('[UserService] User created', ['id' => $user->id]);

            return response()->json($user, 201);

        } catch (ValidationException $e) {
            // RETURN 422
            Log::warning('[UserService] Validation failed', [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            // RETURN 500
            Log::error('[UserService] Error creating user', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // GET USER BY ID
    public function show($id)
    {
        Log::info("[UserService] GET /users/{$id}");

        try {
            $user = User::find($id);

            if (!$user) {
                Log::warning('[UserService] User not found', ['id' => $id]);
                return response()->json(['message' => 'User not found'], 404);
            }

            return response()->json($user, 200);

        } catch (\Throwable $e) {
            Log::error('[UserService] Error fetching user', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to fetch user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        Log::info("[UserService] PUT /users/{$id}", ['body' => $request->all()]);

        try {
            $user = User::find($id);

            if (!$user) {
                Log::warning('[UserService] Cannot update. User not found', ['id' => $id]);
                return response()->json(['message' => 'User not found'], 404);
            }

            // VALIDATION
            $request->validate([
                'email' => 'email|unique:users,email,' . $id
            ]);

            $data = $request->only(['name', 'email']);

            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            Log::info('[UserService] User updated', ['id' => $id]);

            return response()->json($user, 200);

        } catch (ValidationException $e) {

            Log::warning('[UserService] Validation failed during update', [
                'id' => $id,
                'errors' => $e->errors()
            ]);

            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {

            Log::error('[UserService] Error updating user', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to update user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // DELETE USER
    public function destroy($id)
    {
        Log::info("[UserService] DELETE /users/{$id}");

        try {
            $user = User::find($id);

            if (!$user) {
                Log::warning('[UserService] Cannot delete. User not found', ['id' => $id]);
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->delete();

            Log::info('[UserService] User deleted', ['id' => $id]);

            return response()->json(['message' => 'User deleted'], 200);

        } catch (\Throwable $e) {
            Log::error('[UserService] Error deleting user', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to delete user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
