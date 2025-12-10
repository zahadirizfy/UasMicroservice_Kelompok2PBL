<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClubRequest;
use App\Models\Club;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClubApiController extends Controller
{
    /**
     * Display a listing of the clubs.
     * 
     * GET /api/v1/clubs
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 15);
            $clubs = Club::paginate($perPage);

            Log::info('Club list retrieved successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'total' => $clubs->total(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Daftar club berhasil diambil',
                'data' => $clubs->items(),
                'meta' => [
                    'current_page' => $clubs->currentPage(),
                    'last_page' => $clubs->lastPage(),
                    'per_page' => $clubs->perPage(),
                    'total' => $clubs->total(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve club list', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created club.
     * 
     * POST /api/v1/clubs
     */
    public function store(ClubRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            
            // Set default user_id jika tidak ada (untuk API tanpa auth)
            if (!isset($validated['user_id'])) {
                $validated['user_id'] = $request->input('user_id', 1);
            }

            $club = Club::create($validated);

            Log::info('Club created successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $club->id,
                'club_name' => $club->nama,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club berhasil ditambahkan',
                'data' => $club,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create club', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'error' => $e->getMessage(),
                'input' => $request->except(['password']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified club.
     * 
     * GET /api/v1/clubs/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('Club not found', [
                    'correlation_id' => $request->header('X-Correlation-ID'),
                    'club_id' => $id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club tidak ditemukan',
                    'error' => 'Not Found',
                ], 404);
            }

            Log::info('Club detail retrieved successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $club->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detail club berhasil diambil',
                'data' => $club,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve club detail', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified club.
     * 
     * PUT /api/v1/clubs/{id}
     */
    public function update(ClubRequest $request, int $id): JsonResponse
    {
        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('Club not found for update', [
                    'correlation_id' => $request->header('X-Correlation-ID'),
                    'club_id' => $id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club tidak ditemukan',
                    'error' => 'Not Found',
                ], 404);
            }

            $validated = $request->validated();
            $club->update($validated);

            Log::info('Club updated successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $club->id,
                'club_name' => $club->nama,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club berhasil diperbarui',
                'data' => $club->fresh(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update club', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified club.
     * 
     * DELETE /api/v1/clubs/{id}
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('Club not found for deletion', [
                    'correlation_id' => $request->header('X-Correlation-ID'),
                    'club_id' => $id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club tidak ditemukan',
                    'error' => 'Not Found',
                ], 404);
            }

            $clubName = $club->nama;
            $club->delete();

            Log::info('Club deleted successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'club_name' => $clubName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club berhasil dihapus',
                'data' => null,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete club', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

