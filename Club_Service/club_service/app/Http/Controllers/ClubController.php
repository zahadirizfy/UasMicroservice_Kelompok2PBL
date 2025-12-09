<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ClubController extends Controller
{
    /**
     * GET ALL CLUBS
     * GET /api/clubs
     */
    public function index(Request $request)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info('[ClubService] GET /clubs called', [
            'correlation_id' => $cid
        ]);

        try {
            $clubs = Club::all();

            return response()->json([
                'success' => true,
                'message' => 'Clubs retrieved successfully',
                'data' => $clubs
            ], 200)->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[ClubService] Error fetching clubs', [
                'correlation_id' => $cid,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch clubs',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    /**
     * CREATE CLUB
     * POST /api/clubs
     */
    public function store(Request $request)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info('[ClubService] POST /clubs called', [
            'correlation_id' => $cid,
            'body' => $request->all()
        ]);

        try {
            // VALIDATION
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:clubs,name',
                'description' => 'nullable|string|max:1000',
                'city' => 'required|string|max:255',
                'stadium' => 'nullable|string|max:255',
                'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
                'logo_url' => 'nullable|url|max:500',
            ]);

            // CREATE CLUB
            $club = Club::create($validated);

            Log::info('[ClubService] Club created', [
                'correlation_id' => $cid,
                'club_id' => $club->id,
                'club_name' => $club->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club created successfully',
                'data' => $club
            ], 201)->header('X-Correlation-ID', $cid);

        } catch (ValidationException $e) {

            Log::warning('[ClubService] Validation failed', [
                'correlation_id' => $cid,
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422)->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[ClubService] Error creating club', [
                'correlation_id' => $cid,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create club',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    /**
     * GET CLUB BY ID
     * GET /api/clubs/{id}
     */
    public function show(Request $request, $id)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info("[ClubService] GET /clubs/{$id}", [
            'correlation_id' => $cid
        ]);

        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('[ClubService] Club not found', [
                    'correlation_id' => $cid,
                    'club_id' => $id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club not found'
                ], 404)->header('X-Correlation-ID', $cid);
            }

            return response()->json([
                'success' => true,
                'message' => 'Club retrieved successfully',
                'data' => $club
            ], 200)->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[ClubService] Error fetching club', [
                'correlation_id' => $cid,
                'club_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch club',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    /**
     * UPDATE CLUB
     * PUT /api/clubs/{id}
     */
    public function update(Request $request, $id)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info("[ClubService] PUT /clubs/{$id}", [
            'correlation_id' => $cid,
            'body' => $request->all()
        ]);

        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('[ClubService] Cannot update. Club not found', [
                    'correlation_id' => $cid,
                    'club_id' => $id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club not found'
                ], 404)->header('X-Correlation-ID', $cid);
            }

            // VALIDATION
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255|unique:clubs,name,' . $id,
                'description' => 'nullable|string|max:1000',
                'city' => 'sometimes|string|max:255',
                'stadium' => 'nullable|string|max:255',
                'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
                'logo_url' => 'nullable|url|max:500',
            ]);

            $club->update($validated);

            Log::info('[ClubService] Club updated', [
                'correlation_id' => $cid,
                'club_id' => $id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club updated successfully',
                'data' => $club
            ], 200)->header('X-Correlation-ID', $cid);

        } catch (ValidationException $e) {

            Log::warning('[ClubService] Validation failed during update', [
                'correlation_id' => $cid,
                'club_id' => $id,
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422)->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[ClubService] Error updating club', [
                'correlation_id' => $cid,
                'club_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update club',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }

    /**
     * DELETE CLUB
     * DELETE /api/clubs/{id}
     */
    public function destroy(Request $request, $id)
    {
        $cid = $request->attributes->get('correlation_id');

        Log::info("[ClubService] DELETE /clubs/{$id}", [
            'correlation_id' => $cid
        ]);

        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('[ClubService] Cannot delete. Club not found', [
                    'correlation_id' => $cid,
                    'club_id' => $id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club not found'
                ], 404)->header('X-Correlation-ID', $cid);
            }

            $clubName = $club->name;
            $club->delete();

            Log::info('[ClubService] Club deleted', [
                'correlation_id' => $cid,
                'club_id' => $id,
                'club_name' => $clubName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club deleted successfully'
            ], 200)->header('X-Correlation-ID', $cid);

        } catch (\Throwable $e) {

            Log::error('[ClubService] Error deleting club', [
                'correlation_id' => $cid,
                'club_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete club',
                'error' => $e->getMessage(),
            ], 500)->header('X-Correlation-ID', $cid);
        }
    }
}

