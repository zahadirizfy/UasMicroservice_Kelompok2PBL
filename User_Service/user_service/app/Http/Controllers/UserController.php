<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // GET ALL USERS
    public function index(Request $request)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info('[UserService] GET /users called', [
            'correlation_id' => $cid
        ]);

        try {
            $users = User::all();

            return response()->json($users, 200)
                ->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[UserService] Error fetching users', [
                'correlation_id' => $cid,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to fetch users',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    // CREATE USER
    public function store(Request $request)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info('[UserService] POST /users called', [
            'correlation_id' => $cid,
            'body' => $request->all()
        ]);

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

            Log::info('[UserService] User created', [
                'correlation_id' => $cid,
                'id' => $user->id
            ]);

            return response()->json($user, 201)
                ->header('X-Correlation-ID', $cid);

        } catch (ValidationException $e) {

            Log::warning('[UserService] Validation failed', [
                'correlation_id' => $cid,
                'errors' => $e->errors()
            ]);

            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422)->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[UserService] Error creating user', [
                'correlation_id' => $cid,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    // GET USER BY ID
    public function show(Request $request, $id)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info("[UserService] GET /users/{$id}", [
            'correlation_id' => $cid
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                Log::warning('[UserService] User not found', [
                    'correlation_id' => $cid,
                    'id' => $id
                ]);

                return response()->json(['message' => 'User not found'], 404)
                    ->header('X-Correlation-ID', $cid);
            }

            return response()->json($user, 200)
                ->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[UserService] Error fetching user', [
                'correlation_id' => $cid,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to fetch user',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info("[UserService] PUT /users/{$id}", [
            'correlation_id' => $cid,
            'body' => $request->all()
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                Log::warning('[UserService] Cannot update. User not found', [
                    'correlation_id' => $cid,
                    'id' => $id
                ]);

                return response()->json(['message' => 'User not found'], 404)
                    ->header('X-Correlation-ID', $cid);
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

            Log::info('[UserService] User updated', [
                'correlation_id' => $cid,
                'id' => $id
            ]);

            return response()->json($user, 200)
                ->header('X-Correlation-ID', $cid);

        } catch (ValidationException $e) {

            Log::warning('[UserService] Validation failed during update', [
                'correlation_id' => $cid,
                'id' => $id,
                'errors' => $e->errors()
            ]);

            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422)->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[UserService] Error updating user', [
                'correlation_id' => $cid,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to update user',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    // DELETE USER
    public function destroy(Request $request, $id)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info("[UserService] DELETE /users/{$id}", [
            'correlation_id' => $cid
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                Log::warning('[UserService] Cannot delete. User not found', [
                    'correlation_id' => $cid,
                    'id' => $id
                ]);

                return response()->json(['message' => 'User not found'], 404)
                    ->header('X-Correlation-ID', $cid);
            }

            $user->delete();

            Log::info('[UserService] User deleted', [
                'correlation_id' => $cid,
                'id' => $id
            ]);

            return response()->json(['message' => 'User deleted'], 200)
                ->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[UserService] Error deleting user', [
                'correlation_id' => $cid,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to delete user',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }
}
